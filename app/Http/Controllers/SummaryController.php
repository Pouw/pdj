<?php

namespace App\Http\Controllers;

use App\Libraries\PriceSummarize;
use App\Price;
use App\RegistrationStatus;
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

		if ($user->registration->registration_status_id == RegistrationStatus::UNFINISHED) {
			Mail::send('emails.summary', $data, function ($m) use ($user) {
				$m->to($user->email, $user->name)->subject('Prague Rainbow Spring 2017 - registration summary');
			});
			$user->registration->registration_status_id = RegistrationStatus::NEW;
			$user->registration->save();
			$data['newRegistration'] = true;
		}
		return view('summary', $data);
	}

	public function save(Request $request) {
		return redirect('/payment');
	}

}
