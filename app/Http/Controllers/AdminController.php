<?php

namespace App\Http\Controllers;

use App\Note;
use App\Payments;
use App\Price;
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

	public function index(Request $request)
	{
		$user = Auth::user();
		$data = [
			'user' => $user,
		];
		return view('admin', $data);
	}

	public function registrations(Request $request) {
		$sportId = intval($request->get('sport_id'));
		$states = (array) $request->get('states');
		$service = $request->get('service');
		$data = [
			'sportId' => $sportId,
			'states' => $states,
			'service' => $service,
		];

		if (!empty($states) || !empty($service) || !empty($sportId)) {
			$sportRegistrations = new \App\RegistrationSport();
			if (!empty($states) || !empty($service)) {
				$sportRegistrations = $sportRegistrations->whereHas('registration', function ($query) use ($states, $service) {
					if (!empty($states)) {
						$query->whereIn('registrations.state', $states);
					}
					if ($service === 'concert') {
						$query->where('registrations.concert', '>', 0);
					} elseif ($service === 'brunch') {
						$query->where('registrations.brunch', '>', 0);
					} elseif ($service === 'hosted_housing') {
						$query->where('registrations.hosted_housing', '>', 0);
					} elseif ($service === 'outreach_support') {
						$query->where('registrations.outreach_support', '>', 0);
					} elseif ($service === 'outreach_request') {
						$query->where('registrations.outreach_request', '>', 0);
					}
				});
			}
			if (!empty($sportId)) {
				$sportRegistrations = $sportRegistrations->whereSportId($sportId);
			};
			$data['sportRegistrations'] = $sportRegistrations->groupBy('registration_id')->get();
		}

		return view('admin.registrations', $data);
	}

	public function registration(Request $request) {
		$id = $request->get('id');
		$registration = Registration::findOrFail($id);
		$user = User::findOrFail($registration->user_id);
		$data = [
			'registration' => $registration,
			'user' => $user,
			'price' => new Price(),
		];
		return view('admin.registration', $data);
	}

	public function registrationSave(Request $request) {
		$id = $request->get('id');
		$registration = Registration::findOrFail($id);
		$registration->state = $request->get('state');
		$registration->save();

		$request->session()->flash('alert-success', 'Data has been saved.');
		return back();
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

	public function payments(Request $request) {
		$data = [
			'payments' => Payments::get(),
		];
		return view('admin.payments', $data);
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
			'user_id' => Auth::user()->id,
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

	public function noteAdd(Request $request) {
		Note::insert([
			'registration_id' => $request->get('registration_id'),
			'content' => $request->get('content'),
			'user_id' => Auth::user()->id,
		]);

		$request->session()->flash('alert-success', 'Data has been saved.');
		return back();
	}

	public function mailTest() {
		$user = Auth::user();
		Mail::send('emails.test', ['user' => $user], function ($m) use ($user) {
			$m->to($user->email, $user->name)->subject('Your Reminder!');
		});
	}

}
