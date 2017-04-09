<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $currency_id
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_admin'
    ];

	public function registration() {
		return $this->hasOne(\App\Registration::class);
	}

	public function isAdmin(): bool {
		return intval($this->is_admin) === 1;
	}

	public function currency() {
		return $this->belongsTo(\App\Currency::class);
	}

	public function country() {
		return $this->belongsTo(\App\Country::class);
	}

	public function hasFinishedRegistration() {
		$registration = $this->registration();
		if ($registration->count() > 0) {
			if (in_array($registration->first()->state, [\App\Registration::NEW, \App\Registration::PAID])) {
				return true;
			}
		}
		return false;
	}

}
