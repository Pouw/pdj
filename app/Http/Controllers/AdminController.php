<?php

namespace App\Http\Controllers;

use App\Payments;
use App\Registration;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('admin');
	}



	public function users(Request $request) {
		$countryId = $request->get('country_id');
		$name = $request->get('name');
		$users = new User();
		if ($countryId) {
			$users = $users->whereCountryId($countryId);
		}
		if ($name) {
			$users = $users->where('name', 'LIKE', "%$name%");
		}

		$data = [
			'name' => $name,
			'countryId' => $countryId,
			'users' => $users->get(),
		];
		return view('admin.users', $data);
	}

	public function paymentAdd(Request $request) {
		$id = $request->get('id');
		$registration = Registration::findOrFail($id);

		$amount = $request->get('amount');
		$amount = (int) str_replace(' ', '', $amount);
		$currencyId = (int) $request->get('currency_id');

		Payments::insert([
			'state' => Payments::PAID,
			'registration_id' => $id,
			'amount' => $amount,
			'currency_id' => $currencyId,
			'user_id' => $request->user()->id,
		]);

		if ($request->get('set_paid') === '1') {
			$registration->state = Registration::PAID;
			$registration->save();
		}
		if ($request->get('send_mail') === '1') {
			$data = [
				'registration' => $registration,
				'amount' => $amount,
				'currencyId' => $currencyId,
			];
			Mail::send('emails.payment', $data, function ($m) use ($registration) {
				$m->to($registration->user->email, $registration->user->name)
					->bcc('form@praguerainbow.eu')
					->subject('Prague Rainbow Spring - Payment Confirmation');
			});
		}
		$request->session()->flash('alert-success', 'Data has been saved.');
		return back();
	}

	public function mailTest() {
		$user = Auth::user();
		Mail::send('emails.test', ['user' => $user], function ($m) use ($user) {
			$m->to($user->email, $user->name)->subject('Your Reminder!');
		});
	}

	public function fixPaid() {
		$payments = Payments::where('bank_status', 7)->get();
		foreach($payments as $payment) {
			$reg = $payment->registration;
			if ($reg->state == Registration::NEW) {
				dump($reg->id);
				$reg->state = Registration::PAID;
				$reg->save();
			}
		}
	}



}
