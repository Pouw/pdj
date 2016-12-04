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
			'sports' => Sport::orderBy('sort_key')->get(),
			'user' => $user,
			'defaultSports' => $defaultSports,
		];
		return view('registration', $data);
	}

	public function save(Request $request) {
		$user = Auth::user();
		$sportIds = $request->get('sports');

		$validator = $this->getValidationFactory()->make($request->all(), []);
		if (empty($sportIds)) {
			$validator->errors()->add('checkbox', 'Please, select at least one option!');
		} else {
			if (in_array(Sport::VISITOR, $sportIds) && count($sportIds) > 1) {
				$validator->errors()->add('checkbox', 'You are not visitor if you want to participate');
			}
			if (count(array_intersect($sportIds, [Sport::BADMINTON, Sport::SWIMMING, Sport::SOCCER, Sport::VOLLEYBALL])) >= 2) {
				$validator->errors()->add('checkbox', 'Badminton, Swimming, Soccer and Volleyball are played in same time. You can participate only one of them.');
			}
			if (count(array_intersect($sportIds, [Sport::BEACH_VOLLEYBALL, Sport::RUNNING])) >= 2) {
				$validator->errors()->add('checkbox', 'Beach Volleyball and Running will be held in same time. You can participate only one of them.');
			}
		}
		if (count($validator->errors()) > 0) {
			$this->throwValidationException($request, $validator);
		}


		if (empty($user->registration)) {
			$item = ['user_id' => $user->id];
			$regId = Registration::insertGetId($item);
		} else {
			$regId = $user->registration->id;
		}

		$nextUrl = '/service';
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
			$needMoreInfo = [
				Sport::BADMINTON,
				Sport::BEACH_VOLLEYBALL,
				Sport::RUNNING,
				Sport::SOCCER,
				Sport::SWIMMING,
				Sport::VOLLEYBALL
			];
			if (count(array_intersect($sportIds, $needMoreInfo)) > 0) {
				$nextUrl = '/sport';
			}
		} else {
			RegistrationSport::where('registration_id', $regId)->delete();
		}
		\App\RegistrationLog::log();
		return redirect($nextUrl);
	}

}
