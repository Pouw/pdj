<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\RegistrationChange
 *
 * @property int $id
 * @property int $registration_id
 * @property int $user_id
 * @property string $what
 * @property string $from
 * @property string $to
 * @property \Carbon\Carbon $created_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationChange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationChange whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationChange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationChange whereRegistrationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationChange whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationChange whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationChange whereWhat($value)
 * @mixin \Eloquent
 */
class RegistrationChange extends Model
{
	public function user() {
		return $this->belongsTo(\App\User::class);
	}
}
