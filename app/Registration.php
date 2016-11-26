<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reg
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Registration extends Model
{

	public function sports() {
		return $this->hasMany(\App\RegistrationSport::class);
	}

	public function priceBunch() {

		$prices = Price::whereId(6);
		return $prices;
	}

	public function user() {
		return $this->belongsTo(\App\User::class);
	}

}
