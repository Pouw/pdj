<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Sport;

class SportController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
		if ($request->isMethod('post')) {
			return $this->volleyball();
		}



		$sports = Sport::orderBy('name')->get();
		return view('sport', ['sports' => $sports]);
//		return view('sport');
	}

	protected function volleyball() {
		return view('sports/volleyball');
	}

}
