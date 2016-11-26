<?php

namespace App\Http\Controllers;

use App\Libraries\PriceSummarize;
use App\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

	public function registrations() {
		return view('admin.registrations');
	}

	public function registration(Request $request) {
		$id = $request->get('id');
		$data = [
			'registration' => \App\Registration::findOrFail($id),
		];
		return view('admin.registration', $data);
	}

	public function payments(Request $request) {
		return redirect('/payments');
	}

}