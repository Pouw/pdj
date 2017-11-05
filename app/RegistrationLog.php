<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RegistrationLog
 *
 * @property int $id
 * @property int $registration_id
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationLog whereRegistrationId($value)
 * @mixin \Eloquent
 */
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
