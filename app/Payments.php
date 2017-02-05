<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{

	const UNPAID = 'unpaid';
	const PAID = 'paid';
	const CANCELED = 'canceled';

	public function currency() {
		return $this->belongsTo(\App\Currency::class);
	}

	public function user() {
		return $this->belongsTo(\App\User::class);
	}

}
