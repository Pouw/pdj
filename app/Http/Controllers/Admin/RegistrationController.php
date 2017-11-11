<?php

namespace App\Http\Controllers\Admin;

use App\Note;
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
		$states = (array)$request->get('states');
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

	public function save($id, Request $request) {
		$registration = Registration::findOrFail($id);
		$registration->state = $request->get('state');
		$registration->save();

		$request->session()->flash('alert-success', 'Data has been saved.');
		return back();
	}

	public function noteAdd(Request $request) {
		Note::insert([
			'registration_id' => $request->get('registration_id'),
			'content' => $request->get('content'),
			'user_id' => $request->user()->id,
		]);

		$request->session()->flash('alert-success', 'Data has been saved.');
		return back();
	}

	public function log($id) {
		$reg = Registration::findOrFail($id);
		foreach ($reg->logs as $log) {
			$log->data = json_decode($log->content);
		}
		return view('admin.registration.log', ['logs' => $reg->logs]);
	}

	public function checkPaid() {
		$tournament = Tournament::getActive();
		$registrations = Registration::whereState(Registration::PAID)->whereTournamentId($tournament->id);
		$data = [];
		foreach ($registrations->get() as $reg) {
			$amount = $reg->getPriceSummarize()->getTotalPrice();
			$amountCzk = $amount['czk'];
			$userCurrencyId = $reg->user->currency_id;
			$paid = 0;
			$currencyError = false;
			foreach ($reg->payments as $payment) {
				if ($payment->state != Payments::PAID) {
					continue;
				}
				if ($payment->currency_id == $tournament->currency_id) {
					$paid += $payment->amount;
				} elseif ($userCurrencyId == Currency::EUR && $payment->currency_id == Currency::CZK && $payment->amount_eur > 0) {
					$paid += $payment->amount_eur;
				} else {
					$currencyError = true;
//						dump('WRONG CURRENCY!' . $reg->id);
				}
			}
			if ($amountCzk != $paid || $currencyError) {
				$data[] = [
					'reg' => $reg,
					'amount' => $amountCzk,
					'paid' => $paid,
					'amountsForPay' => $reg->getAmountsForPay()['czk'],
					'currencyError' => $currencyError,
				];
			}
		}
		return view('admin.registration.check_paid', ['data' => $data]);
	}

}
