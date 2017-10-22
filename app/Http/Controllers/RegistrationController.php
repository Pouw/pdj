<?php

namespace App\Http\Controllers;

use App\Tournament;
use Illuminate\Http\Request;
use App\Item;
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
		$user = $request->user();
		if ($user->hasFinishedRegistration()) {
			return redirect('/');
		}
		$defaultSports = [];

		$tournament = Tournament::getActive();
		if (empty($tournament)) {
			return redirect('/');
		}

		$registration = $user->getActiveRegistration();
		if ($registration != null) {
			dd($tournament->items->all());
			$defaultSports = array_column($user->registration->sports->all(), 'sport_id');
		}

		$items = $tournament->items();
		$data = [
			'sports' => $items->orderBy('sort_key')->get(),
			'user' => $user,
			'defaultSports' => $defaultSports,
		];
		return view('registration', $data);
	}

	public function save(Request $request) {
		$user = $request->user();
		$sportIds = $request->get('sports');

		$validator = $this->getValidationFactory()->make($request->all(), []);
		if (empty($sportIds)) {
			$validator->errors()->add('checkbox', 'Please, select at least one option!');
		} else {
			if (in_array(Item::VISITOR, $sportIds) && count($sportIds) > 1) {
				$validator->errors()->add('checkbox', 'You are not a visitor if you wish to participate');
			}
			if (count(array_intersect($sportIds, [Item::BADMINTON, Item::SWIMMING, Item::SOCCER, Item::VOLLEYBALL])) >= 2) {
				$validator->errors()->add('checkbox', 'Badminton, Swimming, Soccer and Volleyball take place in parallel. You can only participate in one of them.');
			}
			if (count(array_intersect($sportIds, [Item::BEACH_VOLLEYBALL, Item::RUNNING])) >= 2) {
				$validator->errors()->add('checkbox', 'Beach Volleyball and Running take place in parallel. You can only participate in one of them.');
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
				Item::BADMINTON,
				Item::BEACH_VOLLEYBALL,
				Item::RUNNING,
				Item::SOCCER,
				Item::SWIMMING,
				Item::VOLLEYBALL
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
