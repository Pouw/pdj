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
		$data = [
			'price' => new Price(),
		];
		return view('summary', $data);
	}

	public function save(Request $request) {
		$user = Auth::user();

		if ($user->registration->state == Registration::UNFINISHED) {
			$data = [
				'registration' => $user->registration,
				'price' => new Price(),
			];
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
					->subject('Prague Rainbow Spring - Registration Summary');
			});
			$user->registration->state = Registration::NEW;
			$user->registration->save();
			$request->session()->flash('alert-success', 'Your registration has been successful.');
		}

		return redirect('/payment');
	}

}
