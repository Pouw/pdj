<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MailQueue
 *
 * @property int $id
 * @property int $mail_id
 * @property int $user_id
 * @property int $sent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\Mail $mail
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailQueue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailQueue whereSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailQueue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MailQueue whereUserId($value)
 * @mixin \Eloquent
 */
class MailQueue extends Model {

	protected $table = 'mail_queue';

	public function user() {
		return $this->belongsTo(\App\User::class);
	}

}
