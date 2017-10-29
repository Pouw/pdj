<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 */
class Tournament extends Model
{

	static public function getActive(): Tournament {
		return self::where('status_id', 1)->first();
	}

	public function items() {
		return $this->belongsToMany(Item::class, 'tournament_items')->withPivot(['id', 'status_id']);
	}

}
