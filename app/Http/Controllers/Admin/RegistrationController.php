<?php

namespace App\Http\Controllers\Admin;


use App\Currency;
use App\Payments;
use App\Registration;

class RegistrationController extends Controller
{

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
