<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ActiveTournament;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

	public function __construct() {
		$this->middleware(ActiveTournament::class);
		$this->middleware('auth');
	}

	public function index() {
		$user = Auth::user();
		return view('home', ['user' => $user]);
	}

}
