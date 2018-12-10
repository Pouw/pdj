<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TournamentItem
 *
 * @property int $id
 * @property int $tournament_id
 * @property int $item_id
 * @property int|null $price_id
 * @property int $status_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Item $item
 * @property-read \App\Price|null $price
 * @property-read \App\Tournament $tournament
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TournamentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TournamentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TournamentItem whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TournamentItem wherePriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TournamentItem whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TournamentItem whereTournamentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TournamentItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TournamentItem extends Model
{

	static public function getActive() {
		return self::where('status_id', 1)->get();
	}

	public function tournament() {
		return $this->belongsTo(Tournament::class);
	}

	public function item() {
		return $this->belongsTo(Item::class);
	}

	public function price() {
		return $this->belongsTo(Price::class);
	}

	public function teams() {
		return $this->hasMany(Team::class);
	}

}
