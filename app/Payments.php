<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Payments
 *
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
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Currency $currency
 * @property-read \App\Registration $registration
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereAmountEur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereBankStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments wherePayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereRegistrationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereResultCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereResultText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Payments whereUserId($value)
 * @mixin \Eloquent
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
