<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * App\Tournament
 *
 * @property integer $id
 * @property string $name
 * @property int $currency_id
 * @property \Carbon\Carbon $closed_at
 * @property int $status_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Currency $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Item[] $items
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Registration[] $registrations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tournament findOrFail($id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tournament whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tournament whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tournament whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tournament whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tournament whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tournament whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tournament extends Model
{

	/**
	 * @return Tournament|null
	 */
	static public function getActive() {
		return self::where('status_id', 1)->first();
	}

	public function items() {
		return $this->belongsToMany(Item::class, 'tournament_items')->withPivot(['id', 'status_id']);
	}

	public function currency() {
		return $this->belongsTo(Currency::class);
	}

	public function registrations() {
		return $this->hasMany(Registration::class);
	}

	public function isOpen(): bool {
		$now = Carbon::now();
		$closedAt = new Carbon($this->closed_at);
		return $now->lessThan($closedAt);
	}

}
