<?php

namespace App\Http\Controllers;

use App\Libraries\Signature;
use App\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

	private $myPublicKey = 'test-public.pem';
	private $bankPublicKey = 'muzo.signing_test.pem';


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
		$signature = new Signature($this->myPublicKey);

		$payment = new Payments();
		$payment->registration_id = $user->registration->id;
		$payment->amount = intval($user->registration->getPriceSummarize()->getTotalPrice() * 100);
		$payment->currency_id = $user->currency_id;
		$payment->user_id = $user->id;
		$payment->save();

		$data = [
			'MERCHANTNUMBER' => $_SERVER['WEBPAY_MERCHANT_NUMBER'],
			'OPERATION' => 'CREATE_ORDER',
			'ORDERNUMBER' => $payment->id,
			'AMOUNT' => $payment->amount,
//			'CURRENCY' => intval($user->currency_id) === Currency::CZK ? 203 : 978,
			'CURRENCY' => 203,
			'DEPOSITFLAG' => 0,
			'MERORDERNUM' => $payment->registration_id,
			'URL' => $_SERVER['APP_URL'] . ':80/payment-return',

		];
		$data['DIGEST'] = $signature->sign(implode('|', $data));


		$params = [];
		foreach ($data as $key => $value) {
			$params[] = $key . '=' . urlencode(trim($value));
		}

		return redirect('https://test.3dsecure.gpwebpay.com/pgw/order.do?' . implode('&', $params));
	}

	public function paymentReturn(Request $request) {
		$signature = new Signature($this->bankPublicKey);

		$data = [
			$request->get('OPERATION'),
			$request->get('ORDERNUMBER'),
			$request->get('MERORDERNUM'),
			$request->get('PRCODE'),
			$request->get('SRCODE'),
			$request->get('RESULTTEXT'),
		];
		dump($signature->verify(implode('|', $data), $request->get('DIGEST')));

		$data[] = $_SERVER['WEBPAY_MERCHANT_NUMBER'];
		dump($signature->verify(implode('|', $data), $request->get('DIGEST1')));
		dump($request->all());

	}

}
