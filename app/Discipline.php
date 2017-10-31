<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model {

	static public function swimming() {
		return self::whereItemId(Item::SWIMMING)->orderBy('sort_key')->get();
	}

}
