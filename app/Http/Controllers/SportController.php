<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Sport;
use App\Team;
use App\RegistrationSportDisciplines;

class SportController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$user = Auth::user();
		$data = [
			'user' => $user,
		];
		return view('sport', $data);
	}

	public function save(Request $request) {
		$user = Auth::user();

		$validator = $this->getValidationFactory()->make($request->all(), []);

		foreach ([Sport::VOLLEYBALL => 'volleyball', Sport::SOCCER => 'soccer'] as $sportId => $sportName) {
			if ($request->get($sportName . '_team') === 'create') {
				if (empty($request->get($sportName . '_team_name'))) {
					$validator->errors()->add($sportName . '_team', "Fill in name for your new team.");
				}
				if ($sportId === Sport::VOLLEYBALL) {
					if (empty($request->get($sportName . '_team_level_id'))) {
						$validator->errors()->add($sportName . '_team', "Select level for your new team.");
					}
					if (!empty($request->get($sportName . '_team_name')) && !empty($request->get($sportName . '_team_level_id'))) {
						$team = Team::where('sport_id', $sportId)
							->where('name', $request->get($sportName . '_team_name'))
							->where('level_id', $request->get($sportName . '_team_level_id'));
						if ($team->count() > 0) {
							$validator->errors()->add($sportName . '_team', "Team with this name and level already exist.");
						}
					}
				}
			}
			if ($request->get($sportName . '_team') === 'find' && empty($request->get($sportName . '_team_id'))) {
				$validator->errors()->add($sportName . '_team', "Select your team.");
			}
		}
		foreach ($user->registration->sports as $sport) {
			$sportId = intval($sport->sport->id);
			$sportKey = str_replace(' ', '_', strtolower($sport->sport->name));
			if ($sportId === Sport::BEACH_VOLLEYBALL) {
				if (empty($request->get($sportKey . '_team_name'))) {
					$validator->errors()->add($sportKey . '_team_name', "Fill in your team name for Beach Volleyball.");
				}
			} elseif (in_array($sportId, [Sport::RUNNING, Sport::SWIMMING, Sport::BADMINTON])) {
				if (empty($request->get($sportKey . '_discipline'))) {
					$validator->errors()->add($sportKey . '_discipline', "Select at least one discipline for $sportKey.");
				}
			}
			if ($sportId === Sport::SWIMMING) {
				$disciplinesIds = $request->get($sportKey . '_discipline');
				if (!empty($disciplinesIds)) {
					foreach ($disciplinesIds as $disciplineId) {
						$key = $sportKey . '_discipline_time_' . $disciplineId;
						if (empty($request->get($key))) {
							$validator->errors()->add($key, "Fill in your time for discipline.");
						}
					}
				}
			}
			if ($sportId === Sport::BADMINTON) {
				if (empty($request->get('badminton_level'))) {
					$validator->errors()->add('badminton_level', "Select level for badminton singles or set you don't want to play.");
				}
				if (empty($request->get('badminton_alt_level'))) {
					$validator->errors()->add('badminton_alt_level', "Select level for badminton doubles or set you don't want to play.");
				}
			}
		}

		if (count($validator->errors()) > 0) {
			// TODO save messages
//			foreach ($validator->errors()->getMessages() as $message) {
//				dump($message);
//			}
			$this->throwValidationException($request, $validator);
		}

		try {
//			DB::beginTransaction();
			foreach ($user->registration->sports as $sport) {
				$sportKey = str_replace(' ', '_', strtolower($sport->sport->name));
				if (in_array($sport->sport->id, [Sport::VOLLEYBALL, Sport::SOCCER])) {
					$switch = $request->get($sportKey . '_team');
					if ($switch === 'find') {
						$sport->team_id = $request->get($sportKey . '_team_id');
					} else {
						$newTeam = [
							'name' => $request->get($sportKey . '_team_name'),
							'sport_id' => $sport->sport->id,
							'level_id' => $request->get($sportKey . '_team_level_id'),
						];
						$sport->team_id = Team::insertGetId($newTeam);
					}
				}


				$sport->players = $request->get($sportKey . '_players');
				$levelId = intval($request->get($sportKey . '_level'));
				$sport->level_id = $levelId === 0 ? null : $levelId;
				$altLevelId = intval($request->get($sportKey . '_alt_level'));
				$sport->alt_level_id = $altLevelId === 0 ? null : $altLevelId;
				$sport->club = $request->get($sportKey . '_club');
				$sport->team_name = $request->get($sportKey . '_team_name');
				$sport->captain = $request->get($sportKey . '_captain');
				$sport->find_partner = $request->get($sportKey . '_find_partner');
				$sport->save();

				if (intval($sport->sport->id) === Sport::SWIMMING) {
					foreach ($sport->disciplines as $discipline) {
						$discipline->time = $request->get($sportKey . '_discipline_time_' . $discipline->discipline->id);
						$discipline->save();
					}
					$oldDisciplineIds = array_column($sport->disciplines->toArray(), 'discipline_id');
					$newDisciplineIds = $request->get($sportKey . '_discipline', []);
					$deleteIds = array_diff($oldDisciplineIds, $newDisciplineIds);
					$insertIds = array_diff($newDisciplineIds, $oldDisciplineIds);
					foreach ($deleteIds as $deleteId) {
						RegistrationSportDisciplines::where('registration_sport_id', $sport->id)->where('discipline_id', $deleteId)->delete();
					}
					foreach ($insertIds as $disciplineId) {
						$item = [
							'registration_sport_id' => $sport->id,
							'discipline_id' => $disciplineId,
							'time' => $request->get($sportKey . '_discipline_time_' . $disciplineId),
						];
						RegistrationSportDisciplines::insert($item);
					}
				}
				if (in_array($sport->sport->id, [Sport::RUNNING, Sport::BADMINTON])) {
					RegistrationSportDisciplines::where('registration_sport_id', $sport->id)->delete();
					$item = [
						'registration_sport_id' => $sport->id,
						'discipline_id' => $request->get($sportKey . '_discipline'),
					];
					RegistrationSportDisciplines::insert($item);
				}
			}
//			DB::commit();
		} catch (\Error $ex) {
//			DB::rollback();
			throw $ex;
		}
		\App\RegistrationLog::log();

//		return back()->withInput();
		return redirect('/service');
	}

}
