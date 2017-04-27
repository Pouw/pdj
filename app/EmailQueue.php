<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model {

	protected $table = 'email_queue';

	public function user() {
		return $this->belongsTo(\App\User::class);
	}
}
