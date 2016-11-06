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
		$user->registration->outreach_support = $request->get('outreach_support');
		$user->registration->outreach_request = $request->get('outreach_request');
		$user->registration->visitor = $request->get('visitor');
		$user->registration->note = $request->get('note');
		$user->registration->save();
		\App\RegistrationLog::log();
		return redirect('/summary');
	}

}
