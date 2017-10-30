<?php

namespace App\Http\Controllers\Admin;

use App\Price;
use App\Tournament;
use App\TournamentItem;
use Illuminate\Http\Request;
use App\Currency;
use App\Payments;
use App\Registration;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller {

	public function overview(Request $request) {
		$tournamentId = $request->get('tournament_id');
		$tournament = Tournament::getActive();
		if (!isset($tournamentId) && isset($tournament)) {
			$tournamentId = $tournament->id;
		}
		if (!isset($tournamentId)) {
			$tournamentId = Tournament::orderBy('id', 'desc')->first()->id;
		}
		$data = [
			'tournamentId' => $tournamentId,
		];
		return view('admin.registration.overview', $data);
	}

	public function list(Request $request) {
		$tournamentId = $request->get('tournament_id');
		$itemId = $request->get('item_id');
		$states = (array) $request->get('states');
		$service = $request->get('service');
		DB::enableQueryLog();
		$query = new Registration();
		$query = $query->select('registrations.*');
		if ($tournamentId) {
			$query = $query->whereTournamentId($tournamentId);
		}
		if (!empty($states)) {
			$query = $query->whereIn('state', $states);
		}
		if (!empty($service)) {
			if ($service === 'concert') {
				$query = $query->where('concert', '>', 0);
			} elseif ($service === 'brunch') {
				$query = $query->where('brunch', '>', 0);
			} elseif ($service === 'hosted_housing') {
				$query = $query->where('hosted_housing', '>', 0);
			} elseif ($service === 'outreach_support') {
				$query = $query->where('outreach_support', '>', 0);
			} elseif ($service === 'outreach_request') {
				$query = $query->where('outreach_request', '>', 0);
			}
		}
		if ($itemId) {
			$query = $query->join('registration_items', 'registration_items.registration_id', '=', 'registrations.id');

			$tournamentItemId = TournamentItem::whereTournamentId($tournamentId)->whereItemId($itemId)->first()->id;
			$query = $query->where('registration_items.tournament_item_id', $tournamentItemId);
		}
		$registrations = $query->get();

//		dump(DB::getQueryLog());

		$data = [
			'registrations' => $registrations,
			'tournamentId' => $tournamentId,
			'itemId' => $itemId,
			'states' => $states,
			'service' => $service,
		];
		return view('admin.registration.list', $data);
	}

	public function edit($id) {
		$registration = Registration::findOrFail($id);
		$data = [
			'registration' => $registration,
			'price' => new Price(),
		];
		return view('admin.registration.edit', $data);
	}

	public function log($id) {
		$reg = Registration::findOrFail($id);
		foreach ($reg->logs as $log) {
			$log->data = json_decode($log->content);
		}
		return view('admin.registration.log', ['logs' => $reg->logs]);
	}

	public function checkPaid() {
		$regs = Registration::whereState(Registration::PAID)->get();
		$data = [];
		foreach ($regs as $reg) {
			$amount = $reg->getPriceSummarize()->getTotalPrice();
			$userCurrencyId = $reg->user->currency_id;
			$reg->getAmountsForPay();
			$paid = 0;
			$payments = $reg->payments()->where('state', Payments::PAID);
			$currencyError = false;
			if ($payments->count() > 0) {
				foreach ($payments->get() as $payment) {
					if ($payment->currency_id == $userCurrencyId) {
						$paid += $payment->amount;
					} elseif ($userCurrencyId == Currency::EUR && $payment->currency_id == Currency::CZK && $payment->amount_eur > 0) {
						$paid += $payment->amount_eur;
					} else {
						$currencyError = true;
//						dump('WRONG CURRENCY!' . $reg->id);
					}
				}
			}
			if ($amount != $paid || $currencyError) {
				$data[] = [
					'reg' => $reg,
					'amount' => $amount,
					'paid' => $paid,
					'currencyError' => $currencyError
				];
			}
		}
		return view('admin.registration.check_paid', ['data' => $data]);
	}

}
