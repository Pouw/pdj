<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{

	static public function getActive() {
		return self::where('status_id', 1)->first();
	}

	public function items() {
		return $this->belongsToMany(Item::class, 'tournament_items')->withPivot('status_id');
	}

}
