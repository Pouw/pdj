<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationItemDiscipline extends Model
{
	public function discipline() {
		return $this->belongsTo(Discipline::class);
	}
}
