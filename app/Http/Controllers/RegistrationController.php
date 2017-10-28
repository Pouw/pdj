<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ActiveTournament;
use App\RegistrationLog;
use App\Rules\VisitorOnly;
use App\Rules\FirstDayItemsCombination;
use App\Rules\SecondDayItemsCombination;
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
		$this->middleware(ActiveTournament::class);
	}

	public function index(Request $request)
	{
		$user = $request->user();
		if ($user->hasFinishedRegistration()) {
			return redirect('/');
		}
		$defaultSports = [];

		$registration = $user->getActiveRegistration();
		if ($registration != null) {
			$defaultSports = array_column($user->registration->sports->all(), 'sport_id');
		}

		$tournament = Tournament::getActive();
		$items = $tournament->items();
		$data = [
			'items' => $items->orderBy('sort_key')->get(),
			'user' => $user,
			'defaultSports' => $defaultSports,
		];
		return view('registration', $data);
	}

	public function save(Request $request) {
		$request->validate([
			'tournament_item_ids' => ['required', new VisitorOnly, new FirstDayItemsCombination, new SecondDayItemsCombination],
		], [
			'tournament_item_ids.required' => 'Please, select at least one option!'
		]);

		$user = $request->user();
		if (empty($user->registration)) {
			$item = ['user_id' => $user->id];
			$regId = Registration::insertGetId($item);
		} else {
			$regId = $user->registration->id;
		}

		$nextUrl = '/service';
		$sportIds = $request->get('tournament_item_ids');
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
		RegistrationLog::log();
		return redirect($nextUrl);
	}

}
