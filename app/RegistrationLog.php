<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationLog extends Model
{

	public static function log(Registration $registration) {
		if ($registration->registrationItems->count() > 0) {
			foreach ($registration->registrationItems as $registrationItem) {
				$registrationItem->disciplines; // Intentionally, just load data for log
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
