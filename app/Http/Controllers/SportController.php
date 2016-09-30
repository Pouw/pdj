<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Sport;
use App\RegistrationSportDisciplines;

class SportController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$user = Auth::user();

//		$plucked = $user->registration->sports->pluck('sport_id');
//		$selectedSportIds = $plucked->all();

		$data = [
			'user' => $user,
		];
		return view('sport', $data);
	}

	public function save(Request $request) {
		$user = Auth::user();
		foreach ($user->registration->sports as $sport) {
			$sportKey = str_replace(' ', '_', strtolower($sport->sport->name));
			$sport->players = $request->get($sportKey . '_players');
			$sport->level_id = $request->get($sportKey . '_level');
			$sport->club = $request->get($sportKey . '_club');
			$sport->team = $request->get($sportKey . '_team');
			$sport->captain = $request->get($sportKey . '_captain');
			$sport->save();
			if ($sport->sport->id === Sport::BADMINTON) {
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
			}
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

//		return back()->withInput();
		return redirect('/service');
	}

}
