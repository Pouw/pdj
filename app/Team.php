<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	public function level() {
		return $this->belongsTo(\App\Level::class);
	}
}
