<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
	use Notifiable;

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

	public function registrations() {
		return $this->hasMany(Registration::class);
	}

	public function isAdmin(): bool {
		return intval($this->is_admin) === 1;
	}

	public function currency() {
		return $this->belongsTo(Currency::class);
	}

	public function country() {
		return $this->belongsTo(Country::class);
	}

	public function hasFinishedActiveRegistration() {
		$registration = $this->getActiveRegistration();
		if ($registration) {
			if (in_array($registration->state, [Registration::NEW, Registration::PAID])) {
				return true;
			}
		}
		return false;
	}

	public function getActiveRegistration() {
		$tournament = Tournament::getActive();
		if ($tournament) {
			return $this->registrations()->whereTournamentId($tournament->id)->whereUserId($this->id)->first();
		}
		return null;
	}

}
