<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{

	public function currency() {
		return $this->belongsTo(\App\Currency::class);
	}

	public function user() {
		return $this->belongsTo(\App\User::class);
	}

}
