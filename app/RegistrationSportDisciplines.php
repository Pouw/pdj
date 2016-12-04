<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationSportDisciplines extends Model
{
	public function discipline() {
		return $this->belongsTo(\App\Discipline::class);
	}
}
