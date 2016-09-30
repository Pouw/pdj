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
		$user = Auth::user();
		$defaultSports = [];
		if ($user->registration != null) {
			$defaultSports = array_column($user->registration->sports->all(), 'sport_id');
		}
		$data = [
			'sports' => Sport::orderBy('name')->get(),
			'user' => $user,
			'defaultSports' => $defaultSports,
		];
		return view('registration', $data);
	}

	public function save(Request $request) {
		$user = Auth::user();


		$validator = $this->getValidationFactory()->make($request->all(), []);
		if ($request->get('sports') == null && $request->get('visitor') == null) {
			$validator->errors()->add('checkbox', 'Please, select some option!');
			$this->throwValidationException($request, $validator);
		}

		if ($user->registration === null) {
			$item = ['user_id' => $user->id];
			$regId = Registration::insertGetId($item);
		} else {
			$regId = $user->registration->id;
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
			RegistrationSport::where('registration_id', $regId)->delete();
			return redirect('/service');
		}
		return redirect('/sport');
	}

}