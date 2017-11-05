<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EmailQueue
 *
 * @property int $id
 * @property int $user_id
 * @property int $sent
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailQueue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailQueue whereSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailQueue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailQueue whereUserId($value)
 * @mixin \Eloquent
 */
class EmailQueue extends Model {

	protected $table = 'email_queue';

	public function user() {
		return $this->belongsTo(\App\User::class);
	}
}
