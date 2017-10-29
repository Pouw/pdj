<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $state
 * @property integer $registration_id
 * @property integer $amount
 * @property integer $currency_id
 * @property integer $amount_eur
 * @property integer $user_id
 * @property string $pay_id
 * @property integer $bank_status
 * @property integer $result_code
 * @property string $result_text
 *
 */
class Payments extends Model
{

	const UNPAID = 'unpaid';
	const PAID = 'paid';
	const CANCELED = 'canceled';

	public function currency() {
		return $this->belongsTo(\App\Currency::class);
	}

	public function user() {
		return $this->belongsTo(\App\User::class);
	}

	public function registration() {
		return $this->belongsTo(\App\Registration::class);
	}

}
