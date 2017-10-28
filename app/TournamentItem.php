<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentItem extends Model
{

	static public function getActive() {
		return self::where('status_id', 1)->first();
	}

	public function tournament() {
		return $this->belongsTo(Tournament::class);
	}

}
