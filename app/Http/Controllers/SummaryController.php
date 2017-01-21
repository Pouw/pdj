<?php

namespace App\Http\Controllers;

use App\Libraries\PriceSummarize;
use App\Price;
use App\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SummaryController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
		$user = Auth::user();

		$priceSummarize = new PriceSummarize();
		$data = [
			'user' => $user,
			'price' => new Price(),
			'totalPrice' => $priceSummarize->getTotalPrice(),
			'sale' => $priceSummarize->getSale(),
			'newRegistration' => false,
		];

		if ($user->registration->state == Registration::UNFINISHED) {
			Mail::send('emails.summary', $data, function ($m) use ($user) {
				$bcc = [];
				$bcc[] = 'form@praguerainbow.eu';
				foreach ($user->registration->sports as $regSport) {
					if (!empty($regSport->sport->email)) {
						$bcc[] = $regSport->sport->email;
					}
				}

				$m->to($user->email, $user->name)
					->bcc($bcc)
					->subject('Prague Rainbow Spring 2017 - registration summary');
			});
			$user->registration->state = Registration::NEW;
			$user->registration->save();
			$data['newRegistration'] = true;
		}
		return view('summary', $data);
	}

	public function save(Request $request) {
		return redirect('/payment');
	}

}
