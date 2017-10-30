<?php

namespace App\Http\Controllers\Admin;

use App\Tournament;
use Illuminate\Http\Request;
use App\Currency;
use App\Payments;
use App\RegistrationItem;
use App\Registration;

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
		$sportId = intval($request->get('sport_id'));
		$states = (array) $request->get('states');
		$service = $request->get('service');
		$data = [
			'tournamentId' => $tournamentId,
			'sportId' => $sportId,
			'states' => $states,
			'service' => $service,
		];


		if (!empty($states) || !empty($service) || !empty($sportId)) {
			$sportRegistrations = new RegistrationItem();
			if (!empty($states) || !empty($service)) {
				$sportRegistrations = $sportRegistrations->whereHas('registration', function ($query) use ($states, $service) {
					if (!empty($states)) {
						$query->whereIn('registrations.state', $states);
					}
					if ($service === 'concert') {
						$query->where('registrations.concert', '>', 0);
					} elseif ($service === 'brunch') {
						$query->where('registrations.brunch', '>', 0);
					} elseif ($service === 'hosted_housing') {
						$query->where('registrations.hosted_housing', '>', 0);
					} elseif ($service === 'outreach_support') {
						$query->where('registrations.outreach_support', '>', 0);
					} elseif ($service === 'outreach_request') {
						$query->where('registrations.outreach_request', '>', 0);
					}
				});
			}
			if (!empty($sportId)) {
				$sportRegistrations = $sportRegistrations->whereSportId($sportId);
			};
			$data['sportRegistrations'] = $sportRegistrations->groupBy('registration_id')->get();
		}

		return view('admin.registrations', $data);
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
