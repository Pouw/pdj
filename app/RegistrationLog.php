<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RegistrationLog extends Model
{

	public static function log() {
		$user = Auth::user();
		$registration = $user->registration()->first();
		if ($registration->sports->count() > 0) {
			foreach ($registration->sports as $sport) {
				$sport->disciplines; // Intentionally, just load data for log
			}
		}
		$content['registration'] = $registration;
		$item = [
			'registration_id' => $registration->id,
			'content' => json_encode($content),
		];
		self::insert($item);
	}

}
