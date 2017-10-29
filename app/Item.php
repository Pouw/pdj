<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Sport
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Item extends Model
{

	const VOLLEYBALL = 1;
	const BEACH_VOLLEYBALL = 2;
	const SOCCER = 3;
	const SWIMMING = 4;
	const RUNNING = 5;
	const BADMINTON = 6;
	const SINGING = 7;
	const VISITOR = 8;

	public function levels() {
		return $this->hasMany(Level::class);
	}

	public function disciplines() {
		return $this->hasMany(Discipline::class);
	}

	public function teams() {
		return $this->hasMany(Team::class);
	}

	// @deprecated
//	public function price() {
//		return $this->belongsTo(Price::class);
//	}

	public static function getMainSportIds() {
		return [self::BADMINTON, self::SOCCER, self::SWIMMING, self::VOLLEYBALL];
	}

	public function registrations() {
		return $this->hasMany(RegistrationItem::class);
	}

}
