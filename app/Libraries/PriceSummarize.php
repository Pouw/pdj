<?php

namespace App\Libraries;

use App\Currency;
use Illuminate\Support\Facades\Auth;

class PriceSummarize {

	public function getTotalPrice() {
		$user = Auth::user();
		$prices = [];
		foreach ($user->registration->sports as $regSport) {
			$price = $regSport->sport->price;
			$prices[] = $price;
		}

		$sum = 0;
		foreach ($prices as $price) {
			if ($user->member) {
				$sum += $price->czk_member;
				$currency = Currency::CZK;
			} elseif ($user->currency_id === Currency::EUR) {
				$sum += $price->eur;
				$currency = Currency::EUR;
			} elseif ($user->currency_id === Currency::CZK) {
				$sum += $price->czk;
				$currency = Currency::CZK;
			}
		}

		return [
			'price' => $sum,
			'currency' => Currency::whereId($currency)->first(),
		];
	}

}