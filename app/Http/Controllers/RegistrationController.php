<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ActiveTournament;
use App\RegistrationLog;
use App\Rules\VisitorOnly;
use App\Rules\FirstDayItemsCombination;
use App\Rules\SecondDayItemsCombination;
use App\Tournament;
use App\TournamentItem;
use Illuminate\Http\Request;
use App\Registration;
use App\RegistrationItem;

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

		$defaultSports = [];
		$registration = $user->getActiveRegistration();
		if ($registration != null) {
			$registrationItem = $user->getActiveRegistration()->registrationItems->all();
			$defaultSports = array_column($registrationItem, 'tournament_item_id');
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
		$registration = $user->getActiveRegistration();
		if (empty($registration)) {
			$item = [
				'user_id' => $user->id,
				'tournament_id' => Tournament::getActive()->id,
			];
			$registrationId = Registration::insertGetId($item);
		} else {
			$registrationId = $registration->id;
		}

		$tournamentItemIds = $request->get('tournament_item_ids');
		foreach ($tournamentItemIds as $tournamentItemId) {
			$newItem = [
				'registration_id' => $registrationId,
				'tournament_item_id' => $tournamentItemId,
			];
			$registrationItem = RegistrationItem::where($newItem);
			if ($registrationItem->count() === 0) {
				$registrationItem->insert($newItem);
			}
		}
		RegistrationItem::where('registration_id', $registrationId)
			->whereNotIn('tournament_item_id', $tournamentItemIds)
			->delete();
		RegistrationLog::log($registration);

		$tournamentItems = TournamentItem::whereIn('id', $tournamentItemIds);
		foreach ($tournamentItems->get() as $tournamentItem) {
			if ($tournamentItem->item->needs_info) {
				return redirect('/sport');
			}
		}
		return redirect('/service');
	}

}
