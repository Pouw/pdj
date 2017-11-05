<?php

namespace App;

use App\Libraries\PriceHelper;
use App\Libraries\PriceSummarize;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Reg
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $note
 * @property Tournament $tournament
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Registration whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $state
 * @property int $tournament_id
 * @property int|null $brunch
 * @property int $concert
 * @property int|null $hosted_housing
 * @property string|null $hh_from
 * @property string|null $hh_to
 * @property int|null $outreach_support
 * @property int|null $outreach_request
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RegistrationChange[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RegistrationLog[] $logs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Note[] $notes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Payments[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RegistrationItem[] $registrationItems
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Registration whereBrunch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Registration whereConcert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Registration whereHhFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Registration whereHhTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Registration whereHostedHousing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Registration whereOutreachRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Registration whereOutreachSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Registration whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Registration whereTournamentId($value)
 */
class Registration extends Model
{

	private $year = 18;

	const UNFINISHED = 'unfinished';
	const NEW = 'new';
	const PAID = 'paid';
	const CANCELED = 'canceled';
	const TEST = 'test';

	public static $states = ['unfinished', 'new', 'paid', 'canceled', 'test'];

	protected $fillable = [
		'state',
	];

	public function registrationItems() {
		return $this->hasMany(RegistrationItem::class);
	}

	public function priceBunch() {
		$prices = Price::whereId(6);
		return $prices;
	}

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function tournament() {
		return $this->belongsTo(Tournament::class);
	}

	public function getPriceHelper(): PriceHelper {
		return new PriceHelper($this);
	}

	public function getPriceSummarize(): PriceSummarize {
		return new PriceSummarize($this);
	}

	public function isOnlySinger() {
		$registrationItems = $this->registrationItems;
		if ($registrationItems->count() === 1 && intval($registrationItems->first()->item_id) === Item::SINGING) {
			return true;
		}
		return false;
	}

	public function payments() {
		return $this->hasMany(Payments::class);
	}

	public function changes() {
		return $this->hasMany(RegistrationChange::class);
	}

	public function variableSymbol() {
		return '77' . $this->year . sprintf('%06s', $this->id);
	}

	public function paymentPurpose() {
		return 'PRS-' . $this->year  . '-' . sprintf('%06s', $this->id);
	}

	public function save(array $options = []) {
		if ($this->state !== $this->original['state']) {
			$this->changes()->insert([
				'registration_id' => $this->id,
				'what' => 'state',
				'user_id' => \Auth::user()->id,
				'from' => $this->original['state'],
				'to' => $this->state,
			]);
		}
		parent::save($options);
	}

	public function notes() {
		return $this->hasMany(Note::class);
	}

	public function logs() {
		return $this->hasMany(RegistrationLog::class);
	}

	public function getAmountsForPay() {
		$amount = $this->getPriceSummarize()->getTotalPrice();
		$payments = $this->payments()->where('state', Payments::PAID);
		if ($payments->count() > 0) {
			foreach ($payments->get() as $payment) {
				$amount['czk'] -= $payment->amount;
			}
		}

		$amounts = [];
		$amounts['czk'] = $amount['czk'];
		if ($this->user->currency_id == Currency::EUR) {
			$amounts['eur'] = ExchangeRate::czkToEur($amounts['czk']);
		}
		return $amounts;
	}

}
