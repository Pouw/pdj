<?php

namespace App\Http\Controllers;

use App\Libraries\WebPay;
use App\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
		return view('payment');
	}

	public function paymentRedirect() {
		$user = Auth::user();
		$signature = WebPay::getMySignature();

		$payment = new Payments();
		$payment->registration_id = $user->registration->id;
		$payment->amount = $user->registration->getPriceSummarize()->getTotalPrice();
		$payment->currency_id = $user->currency_id;
		$payment->user_id = $user->id;
		$payment->save();

		$data = [
			'MERCHANTNUMBER' => $_SERVER['WEBPAY_MERCHANT_NUMBER'],
			'OPERATION' => 'CREATE_ORDER',
			'ORDERNUMBER' => $payment->id,
			'AMOUNT' => intval($payment->amount) * 100,
			'CURRENCY' => WebPay::getCurrency($user->currency_id),
			'DEPOSITFLAG' => 0,
			'MERORDERNUM' => $user->registration->variableSymbol(),
			'URL' => $_SERVER['APP_URL'] . '/payment-return',
		];
		$data['DIGEST'] = $signature->sign(implode('|', $data));

		$params = [];
		foreach ($data as $key => $value) {
			$params[] = $key . '=' . urlencode(trim($value));
		}

		return redirect(WebPay::getBankUrl() . '?' . implode('&', $params));
	}

	public function paymentReturn(Request $request) {
		$payment = Payments::findOrFail($request->get('ORDERNUMBER'));
		$signature = WebPay::getBankSignature();

		$data = [
			$request->get('OPERATION'),
			$request->get('ORDERNUMBER'),
			$request->get('MERORDERNUM'),
			$request->get('PRCODE'),
			$request->get('SRCODE'),
			$request->get('RESULTTEXT'),
		];
		$sig1 = $signature->verify(implode('|', $data), $request->get('DIGEST'));
		$data[] = $_SERVER['WEBPAY_MERCHANT_NUMBER'];
		$sig2 = $signature->verify(implode('|', $data), $request->get('DIGEST1'));

		$prc = strval($request->get('PRCODE'));
		$src = strval($request->get('SRCODE'));

		$payment->prcode = $prc;
		$payment->srcode = $src;
		$payment->result_text = $request->get('RESULTTEXT');

		if ($sig1 && $sig2 && $prc === '0' && $src === '0') {
			$payment->state = Payments::PAID;
			$request->session()->flash('alert-success', 'Your payment has been accepted.');
		} else {
			$payment->state = Payments::CANCELED;
			$request->session()->flash('alert-danger', "Transaction error:\n" . $request->get('RESULTTEXT'));
		}
		$payment->save();
		return redirect('/payment');
	}

}
