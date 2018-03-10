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
 * @property string|null $title
 * @property string|null $day
 * @property int $price_id
 * @property string|null $email
 * @property int $needs_info
 * @property int $status_id
 * @property int $sort_key
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Discipline[] $disciplines
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Level[] $levels
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RegistrationItem[] $registrations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Team[] $teams
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereNeedsInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item wherePriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereSortKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereTitle($value)
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

	public static function getMainSportIds() {
		return [self::BADMINTON, self::SOCCER, self::SWIMMING, self::VOLLEYBALL];
	}

	/**
	 * @deprecated
	 */
	public function registrations() {
		return $this->hasMany(RegistrationItem::class);
	}

}
