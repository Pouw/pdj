<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Http\Middleware\ActiveTournament;
use App\Libraries\Bank;
use App\Payments;
use App\Registration;
use Illuminate\Http\Request;

class PaymentController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$registration = $request->user()->getActiveRegistration();
		return view('payment', [
			'registration' => $registration,
			'payments' => $registration->payments()->whereState(Payments::PAID),
			'isSinglePage' => $this->isSinglePage($request),
		]);
	}

	public function paymentRedirect(Request $request) {
		$user = $request->user();
		$registration = $request->user()->getActiveRegistration();

		$payment = new Payments();
		$payment->registration_id = $registration->id;
		$amounts = $registration->getAmountsForPay();
		$payment->amount = $amounts['czk'];
		$payment->currency_id = Currency::CZK;
		if ($user->currency_id == Currency::EUR && $payment->registration->tournament->currency_id == Currency::EUR) {
			$payment->amount_eur = $amounts['eur'];
		}
		$payment->user_id = $user->id;
		$payment->save();

		$bc = Bank::getBankClient();
		$bankPayment = Bank::createPayment();
		$bankPayment->orderNo = $payment->id;
		$bankPayment->currency = 'CZK';
		$bankPayment->language = 'EN';
		$bankPayment->addCartItem('Registration for PRS', 1, intval($payment->amount) * 100);
		$bc->paymentInit($bankPayment);
		$payment->pay_id = $bankPayment->getPayId();
		$url = $bc->getPaymentProcessUrl($bankPayment);
		$payment->save();

		return redirect($url);
	}

	public function paymentReturn(Request $request) {
		$bc = Bank::getBankClient();
		$response = $bc->receiveReturningCustomer();
		$status = intval($response['paymentStatus']);
		$payment = Payments::where('pay_id', $response['payId'])->firstOrFail();
		$payment->bank_status = $status;
		$payment->result_code = $response['resultCode'];
		$payment->result_text = $response['resultMessage'];

		// See https://github.com/csob/paymentgateway/wiki/eAPI-v1-CZ#user-content-%C5%BDivotn%C3%AD-cyklus-transakce-
		if (in_array($status, [4, 7, 8])) {
			$payment->state = Payments::PAID;
			$request->session()->flash('alert-success', 'Your payment has been accepted.');
		} else {
			$payment->state = Payments::CANCELED;
			$msg = '';
			if ($status === 3) {
				$msg = 'Payment has been canceled by user.';
			} elseif ($status === 6) {
				$msg = 'Payment has been rejected.';
			}
			$request->session()->flash('alert-danger', "Transaction error:\n$msg");
		}
		$payment->save();

		if ($payment->state == Payments::PAID) {
			$reg = $payment->registration;
			$reg->state = Registration::PAID;
			$reg->save();
		}

		return redirect('/payment');
	}

}
