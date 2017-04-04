<?php

namespace App\Http\Controllers;

use App\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OndraKoupil\Csob\Config;
use OndraKoupil\Csob\Client;
use OndraKoupil\Csob\GatewayUrl;
use OndraKoupil\Csob\Payment;

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

	private function getBankClient() {
		$config = new Config(
			'M1E3CB1201', // My Merchant ID
			base_path('cert') . DIRECTORY_SEPARATOR . 'rsa_M1E3CB1201.key', // path/to/my/private/key/file.key
			base_path('cert') . DIRECTORY_SEPARATOR . 'mips_platebnibrana.csob.cz.pub', // path/to/bank/public/key.pub
			'Rainbow Prague Spring', // My shop name

			// Adresa, kam se mají zákazníci vracet poté, co zaplatí
			$_SERVER['APP_URL'] . '/payment/return',

			// URL adresa API - výchozí je adresa testovacího (integračního) prostředí,
			// až budete připraveni přepnout se na ostré rozhraní, sem zadáte
			// adresu ostrého API.
			GatewayUrl::PRODUCTION_LATEST
		);

		$client = new Client($config);
		return $client;
	}

	public function paymentRedirect() {
		$user = Auth::user();
		$bc = $this->getBankClient();

		$payment = new Payments();
		$payment->registration_id = $user->registration->id;
		$payment->amount = $user->registration->getPriceSummarize()->getTotalPrice();
		$payment->currency_id = $user->currency_id;
		$payment->user_id = $user->id;
		$payment->save();

		$bankPayment = new Payment($payment->id);
		$bankPayment->currency = $user->currency->iso;
		$bankPayment->language = 'EN';
		$bankPayment->addCartItem('Registration for PRS', 1, intval($payment->amount) * 100);
		$bc->paymentInit($bankPayment);
		$payment->pay_id = $bankPayment->getPayId();
		$url = $bc->getPaymentProcessUrl($bankPayment);
		$payment->save();

		return redirect($url);
	}

	public function paymentReturn(Request $request) {
		$bc = $this->getBankClient();
		$response = $bc->receiveReturningCustomer();
		$status = intval($response['paymentStatus']);
		$payment = Payments::where('pay_id', $response['payId'])->firstOrFail();
		$payment->bank_status = $status;
		$payment->result_code = $response['resultCode'];
		$payment->result_text = $response['resultMessage'];

		// See https://github.com/csob/paymentgateway/wiki/eAPI-v1-CZ#user-content-%C5%BDivotn%C3%AD-cyklus-transakce-
		if ($status === 4 || $status === 7) {
			$payment->state = Payments::PAID;
			$request->session()->flash('alert-success', 'Your payment has been accepted.');
		} else {
			$payment->state = Payments::CANCELED;
			$msg = '';
			if ($status === 3) {
				$msg = 'Payment has been canceled by user.';
			} elseif ($status === 3) {
				$msg = 'Payment has been rejected.';
			}
			$request->session()->flash('alert-danger', "Transaction error:\n$msg");
		}
		$payment->save();

		return redirect('/payment');
	}

	public function test() {
		$client = $this->getBankClient();
		try {
			dump($client->testPostConnection());
			dump('OK');
		} catch (Exception $e) {
			echo "Something went wrong: " . $e->getMessage();
		}

	}

}
