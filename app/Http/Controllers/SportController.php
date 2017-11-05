<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ActiveTournament;
use App\RegistrationLog;
use DB;
use Illuminate\Http\Request;

use App\Item;
use App\Team;
use App\RegistrationItemDiscipline;

class SportController extends Controller {

	public function __construct() {
		$this->middleware(ActiveTournament::class);
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$data = [
			'user' => $request->user(),
		];
		return view('sport', $data);
	}

	public function save(Request $request) {
		$user = $request->user();
		$registration = $user->getActiveRegistration();
//		$validator = $this->getValidationFactory()->make($request->all(), []);

		$rules = [];
		$messages = [];

		foreach ([Item::VOLLEYBALL => 'volleyball', Item::SOCCER => 'football'] as $itemId => $sportName) {
			if ($request->get($sportName . '_team') === 'create') {
				$teamNameKey = $sportName . '_team_name';
				$rules[$teamNameKey] =  ['required'];
				$messages["$teamNameKey.required"] = "Fill in name for your new team.";
				if ($itemId === Item::VOLLEYBALL) {
					$rules[$teamNameKey] =  ['required'];
					$messages["$teamNameKey.required"] = "Fill in name for your new team.";
					$rules[$sportName . '_team_level_id'] =  ['required'];
					$messages[$sportName . '_team_level_id.required'] =  "Select level for your new team.";
					// TODO
//					if (!empty($request->get($sportName . '_team_name')) && !empty($request->get($sportName . '_team_level_id'))) {
//						$team = Team::where('sport_id', $sportId)
//							->where('name', $request->get($sportName . '_team_name'))
//							->where('level_id', $request->get($sportName . '_team_level_id'));
//						if ($team->count() > 0) {
//							$validator->errors()->add($sportName . '_team', "Team with this name and level already exist.");
//						}
//					}
				}
			}
			if ($request->get($sportName . '_team') === 'find') {
				$rules[$sportName . '_team_id'] = ['required'];
				$messages[$sportName . '_team_id.required'] = "Select your team.";
			}
		}
		foreach ($registration->registrationItems as $registrationItem) {
			$itemId = intval($registrationItem->tournamentItem->item_id);
			$sportKey = str_replace(' ', '_', strtolower($registrationItem->tournamentItem->item->name));
			if ($itemId === Item::BEACH_VOLLEYBALL) {
				$rules[$sportKey . '_team_name'] =  ['required'];
				$messages[$sportKey . '_team_name.required'] = "Fill in your team name for Beach Volleyball.";
			}
			if (in_array($itemId, [Item::RUNNING, Item::SWIMMING, Item::BADMINTON])) {
				$rules[$sportKey . '_discipline'] =  ['required'];
				$messages[$sportKey . '_discipline.required'] = "Select at least one discipline for $sportKey.";
			}
			if ($itemId === Item::SWIMMING) {
				$disciplinesIds = $request->get($sportKey . '_discipline');
				if (!empty($disciplinesIds)) {
					foreach ($disciplinesIds as $disciplineId) {
						$key = $sportKey . '_discipline_time_' . $disciplineId;
						$rules[$key] =  ['required'];
						$messages[$key . '.required'] = "Fill in your time for discipline.";
					}
				}
			}
			if ($itemId === Item::BADMINTON) {
				$rules['badminton_level'] = ['required'];
				$messages['badminton_level.required'] = "Select level for badminton singles or set you don't want to play.";
				$rules['badminton_alt_level'] = ['required'];
				$messages['badminton_alt_level.required'] = "Select level for badminton doubles or set you don't want to play.";
			}
		}

		$request->validate($rules, $messages);

		DB::transaction(function () use ($user, $registration, $request) {
			foreach ($registration->registrationItems as $registrationItem) {
				$tournamentItem = $registrationItem->tournamentItem;
				$sportKey = str_replace(' ', '_', strtolower($registrationItem->tournamentItem->item->name));
				if (in_array($tournamentItem->item_id, [Item::VOLLEYBALL, Item::SOCCER])) {
					$switch = $request->get($sportKey . '_team');
					if ($switch === 'find') {
						$registrationItem->team_id = $request->get($sportKey . '_team_id');
					} else {
						$newTeam = [
							'name' => $request->get($sportKey . '_team_name'),
							'item_id' => $tournamentItem->item_id,
							'level_id' => $request->get($sportKey . '_team_level_id'),
						];
						$registrationItem->team_id = Team::insertGetId($newTeam);
					}
				}


				$registrationItem->players = $request->get($sportKey . '_players');
				$levelId = intval($request->get($sportKey . '_level'));
				$registrationItem->level_id = $levelId === 0 ? null : $levelId;
				$altLevelId = intval($request->get($sportKey . '_alt_level'));
				$registrationItem->alt_level_id = $altLevelId === 0 ? null : $altLevelId;
				$registrationItem->club = $request->get($sportKey . '_club');
				$registrationItem->team_name = $request->get($sportKey . '_team_name');
				$registrationItem->captain = $request->get($sportKey . '_captain');
				$registrationItem->find_partner = $request->get($sportKey . '_find_partner');
				$registrationItem->save();

				if (intval($tournamentItem->item_id) === Item::SWIMMING) {
					foreach ($registrationItem->disciplines as $discipline) {
						$discipline->time = $request->get($sportKey . '_discipline_time_' . $discipline->discipline->id);
						$discipline->save();
					}
					$oldDisciplineIds = array_column($registrationItem->disciplines->toArray(), 'discipline_id');
					$newDisciplineIds = $request->get($sportKey . '_discipline', []);
					$deleteIds = array_diff($oldDisciplineIds, $newDisciplineIds);
					$insertIds = array_diff($newDisciplineIds, $oldDisciplineIds);
					foreach ($deleteIds as $deleteId) {
						RegistrationItemDiscipline::where('registration_item_id', $registrationItem->id)->where('discipline_id', $deleteId)->delete();
					}
					foreach ($insertIds as $disciplineId) {
						$item = [
							'registration_item_id' => $registrationItem->id,
							'discipline_id' => $disciplineId,
							'time' => $request->get($sportKey . '_discipline_time_' . $disciplineId),
						];
						RegistrationItemDiscipline::insert($item);
					}
				}
				if (in_array($tournamentItem->item_id, [Item::RUNNING, Item::BADMINTON])) {
					RegistrationItemDiscipline::where('registration_item_id', $registrationItem->id)->delete();
					$item = [
						'registration_item_id' => $registrationItem->id,
						'discipline_id' => $request->get($sportKey . '_discipline'),
					];
					RegistrationItemDiscipline::insert($item);
				}
			}
		});
		RegistrationLog::log($registration);

		return redirect('/service');
	}

}
