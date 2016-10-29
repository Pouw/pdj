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
		try {
//			DB::beginTransaction();
			foreach ($user->registration->sports as $sport) {
				$sportKey = str_replace(' ', '_', strtolower($sport->sport->name));
				if ($sport->sport->id === Sport::VOLLEYBALL || $sport->sport->id === Sport::SOCCER) {
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
				$sport->team = $request->get($sportKey . '_team');
				$sport->captain = $request->get($sportKey . '_captain');
				$sport->find_partner = $request->get($sportKey . '_find_partner');
				$sport->save();
				/*if ($sport->sport->id === Sport::BADMINTON) {
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
						];
						RegistrationSportDisciplines::insert($item);
					}
				}*/
				if ($sport->sport->id === Sport::SWIMMING) {
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
					// TODO UPDATE
				}
			}
//			DB::commit();
		} catch (\Error $ex) {
//			DB::rollback();
			throw $ex;
		}

//		return back()->withInput();
		return redirect('/service');
	}

}
