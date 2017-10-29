<?php

namespace App\Http\Controllers;

use App\Price;
use App\RegistrationLog;
use Illuminate\Http\Request;

class ServiceController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$data = [
			'registration' => $request->user()->getActiveRegistration(),
			'outreachPrice' => Price::getOutreachSupportPrice(),
		];
		return view('service', $data);
	}

	public function save(Request $request) {
		$registration =  $request->user()->getActiveRegistration();
		$registration->brunch = $request->get('brunch');
//		$registration->concert = $request->get('concert');
		$registration->hosted_housing = $request->get('hosted_housing');
		if ($request->get('hosted_housing') === '1') {
			$range = $request->get('hosted_housing_date_range');
			preg_match_all('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $range, $matches);
			$registration->hh_from = $matches[0][0];
			$registration->hh_to = $matches[0][1];
		}
		$registration->outreach_support = $request->get('outreach_support');
		$registration->outreach_request = $request->get('outreach_request');
		$registration->note = $request->get('note');
		$registration->save();
		RegistrationLog::log($registration);
		return redirect('/summary');
	}

}
