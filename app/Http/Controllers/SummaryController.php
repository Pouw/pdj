<?php

namespace App\Http\Controllers;

use App\Libraries\PriceSummarize;
use App\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
		$user = Auth::user();
		$data = [
			'user' => $user,
			'price' => new Price(),
			'priceSummarize' => new PriceSummarize()
		];
		return view('summary', $data);
	}

}