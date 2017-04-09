<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{

	static public function getLastRate(): float
	{
//		return self::orderBy('date')->firtsOrFail();
		return self::orderBy('date', 'DESC')->limit(1)->get()[0]->rate;
	}

}
