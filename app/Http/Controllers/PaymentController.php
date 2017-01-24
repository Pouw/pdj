<?php

namespace App\Http\Controllers;

use App\Libraries\PriceSummarize;
use App\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Chaching\Chaching;

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



	public function pay(Request $request) {
		$driver = Chaching::GPWEBPAY;
		$authorization = [
			'merchant_id', [
				'key'         => '...../gpwebpay.crt',
				'passphrase'  => 'passphrase',
				'certificate' => '...../gpwebpay.key'
			]
		];
		$options = [];
		$chaching = new Chaching($driver, $authorization, $options);
		$payment = $chaching->request([
			'currency'        => \Chaching\Currencies::EUR,

			'variable_symbol' => 70000000,
			'amount'          => 9.99,
			'description'     => 'My wonderful product',
			'constant_symbol' => '0308',
			'return_email'    => '...',
			'callback'        => 'http://...'
		]);
	}

}
