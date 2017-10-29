<?php

namespace App\Http\Controllers;

use App\Price;
use App\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SummaryController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$data = [
			'price' => new Price(),
			'registration' => $request->user()->getActiveRegistration(),
			'isSinglePage' => $this->isSinglePage($request),
		];
		return view('summary', $data);
	}

	public function save(Request $request) {
		$user = $request->user();
		$registration = $user->getActiveRegistration();

		if ($registration->state == Registration::UNFINISHED) {
			$data = [
				'registration' => $registration,
				'price' => new Price(),
			];
			Mail::send('emails.summary', $data, function ($m) use ($registration) {
				$bcc = [];
				$bcc[] = 'form@praguerainbow.eu';
				foreach ($registration->registrationItems as $registrationItem) {
					$email = $registrationItem->tournamentItem->item->email;
					if (!empty($email)) {
						$bcc[] = $email;
					}
				}

				$m->to($registration->user->email, $registration->user->name)
					->bcc($bcc)
					->subject('Prague Rainbow Spring - Registration Summary');
			});
			$registration->state = Registration::NEW;
			$registration->save();
			$request->session()->flash('alert-success', 'Your registration has been successful.');
		}

		return redirect('/payment');
	}

}
