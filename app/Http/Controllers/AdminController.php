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
		$data = [
			'sportId' => intval($request->get('sport_id')),
		];
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
