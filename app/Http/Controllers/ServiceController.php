<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Price;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$user = Auth::user();
		$data = [
			'user' => $user,
			'outreachPrice' => Price::getOutreachSupportPrice(),
		];
		return view('service', $data);
	}

	public function save(Request $request) {
		$user = Auth::user();
		$user->registration->brunch = $request->get('brunch');
		$user->registration->hosted_housing = $request->get('hosted_housing');
		if ($request->get('hosted_housing') === '1') {
			$range = $request->get('hosted_housing_date_range');
			preg_match_all('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $range, $matches);
			$user->registration->hh_from = $matches[0][0];
			$user->registration->hh_to = $matches[0][1];
		}
		$user->registration->outreach_support = $request->get('outreach_support');
		$user->registration->outreach_request = $request->get('outreach_request');
		$user->registration->visitor = $request->get('visitor');
		$user->registration->note = $request->get('note');
		$user->registration->save();
		\App\RegistrationLog::log();
		return redirect('/summary');
	}

}
