<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ExchangeRate
 *
 * @property int $id
 * @property string $date
 * @property float $rate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExchangeRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExchangeRate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExchangeRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExchangeRate whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExchangeRate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExchangeRate extends Model {

	static public function getLastRate(): float {
		return self::orderBy('date', 'DESC')->first()->rate;
	}

	static public function czkToEur($czk): float {
		$rate = self::getLastRate();
		$eur = $czk / $rate;
		return $eur;
	}

}
