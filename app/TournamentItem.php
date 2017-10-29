<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentItem extends Model
{

	static public function getActive() {
		return self::where('status_id', 1)->get();
	}

	public function tournament() {
		return $this->belongsTo(Tournament::class);
	}

	public function item() {
		return $this->belongsTo(Item::class);
	}

	public function price() {
		return $this->belongsTo(Price::class);
	}

}
