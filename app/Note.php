<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

	public function registraion() {
		return $this->belongsTo(\App\Registration::class);
	}

	public function user() {
		return $this->belongsTo(\App\User::class);
	}

}
