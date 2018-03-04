<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Tournament;
use Illuminate\Support\Facades\Request;

class Controller extends BaseController {

	public function __construct() {
		$this->middleware('auth');
		$this->middleware('admin');
	}

	protected function getTournamentId(): int {
		$tournamentId = Request::capture()->get('tournament_id');
		$tournament = Tournament::getActive();
		if (!isset($tournamentId) && isset($tournament)) {
			$tournamentId = $tournament->id;
		}
		if (!isset($tournamentId)) {
			$tournamentId = Tournament::orderBy('id', 'desc')->first()->id;
		}
		return $tournamentId;
	}

}
