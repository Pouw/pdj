<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sport;
use App\Registration;
use App\RegistrationSport;

class RegistrationController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
		$sports = Sport::orderBy('name')->get();
		$user = Auth::user();
		$plucked = $user->registration->sports->pluck('sport_id');
		$selectedSportIds = $plucked->all();
		$data = [
			'sports' => $sports,
			'user' => $user,
			'selectedSportIds' => $selectedSportIds
		];
		return view('registration', $data);
	}

	public function save(Request $request) {
		$user = Auth::user();
		$reg = $user->registration;

		if ($reg->count() === 0) {
			$item = ['user_id' => $user->id];
			$regId = Registration::insertGetId($item);
		} else {
			$regId = $reg->first()->id;
		}

		$sportIds = $request->get('sports');
		if ($sportIds) {
			foreach ($sportIds as $sportId) {
				$item = [
					'registration_id' => $regId,
					'sport_id' => $sportId,
				];
				$regSport = RegistrationSport::where($item);
				if ($regSport->count() === 0) {
					$regSport->insert($item);
				}
			}
			RegistrationSport::where('registration_id', $regId)
				->whereNotIn('sport_id', $sportIds)
				->delete();
		} else {
			RegistrationSport::where('reg_id', $regId)->delete();
		}
		return redirect('/sport');
	}

}