<?php

namespace App\Http\Controllers;

use App\Libraries\PriceSummarize;
use App\Price;
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
					$query->groupBy('registrations.id');
				});
			}
			if (!empty($sportId)) {
				$sportRegistrations = $sportRegistrations->whereSportId($sportId);
			};
			$data['sportRegistrations'] = $sportRegistrations->get();
		}

		return view('admin.registrations', $data);
	}

	public function registration(Request $request) {
		$id = $request->get('id');
		$registration = \App\Registration::findOrFail($id);
		$user = User::findOrFail($registration->user_id);
		$priceSummarize = new PriceSummarize();
		$priceSummarize->setUser($user);
		$data = [
			'registration' => $registration,
			'user' => $user,
			'price' => new Price(),
			'totalPrice' => $priceSummarize->getTotalPrice(),
			'sale' => $priceSummarize->getSale(),
		];
		return view('admin.registration', $data);
	}

	public function payments(Request $request) {
		return redirect('/payments');
	}

	public function mailTest() {
		$user = Auth::user();
		Mail::send('emails.test', ['user' => $user], function ($m) use ($user) {
			$m->to($user->email, $user->name)->subject('Your Reminder!');
		});
	}

}
