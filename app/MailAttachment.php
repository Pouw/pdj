<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Mail
 *
 * @property int $id
 * @property int $mail_id
 * @property string $path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Mail $mail
 * @property-read \App\MailQueue $queue
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereMailId($value)
 * @mixin \Eloquent
 */
class MailAttachment extends Model {

	public function mail() {
		return $this->belongsTo(\App\Mail::class);
	}

}
