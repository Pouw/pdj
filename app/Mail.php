<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail as Mailer;

/**
 * App\Mail
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property bool $sent_author
 * @property bool $done
 * @property int $status_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\MailQueue $queue
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereUserId($value)
 * @mixin \Eloquent
 */
class Mail extends Model {

	public function user() {
		return $this->belongsTo(\App\User::class);
	}

	public function queue() {
		return $this->hasMany(\App\MailQueue::class);
	}

	public function sendTo(\App\User $user) {
		$data = [
			'user' => $user,
			'mail' => $this,
		];
		Mailer::send('emails.content', $data, function ($m) use ($user) {
			$m->to($user->email, $user->name)
				->subject($this->title);
		});
	}

}
