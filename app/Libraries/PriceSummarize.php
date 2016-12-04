<?php

namespace App\Libraries;

use App\Currency;
use App\Price;
use Illuminate\Support\Facades\Auth;

class PriceSummarize {

	public function getTotalPrice() {
		$user = Auth::user();
		$items = [];
		foreach ($user->registration->sports as $regSport) {
			$price = $regSport->sport->price;
			$items[] = [
				'price' => $price,
				'quantity' => 1,
			];
		}
		if ($user->registration->brunch) {
			$items[] = [
				'price' => Price::getBrunchPrice(),
				'quantity' => 1,
			];
		}
		if ($user->registration->hosted_housing) {
			$items[] = [
				'price' => Price::getHostedHousingPrice(),
				'quantity' => 1,
			];
		}
		if ($user->registration->outreach_support) {
			$items[] = [
				'price' => Price::getOutreachSupportPrice(),
				'quantity' => intval($user->registration->outreach_support),
			];
		}



		$sum = 0;
		$currencyId = intval($user->currency_id);
		foreach ($items as $item) {
			$price = $item['price'];
			if ($user->is_member && $currencyId === Currency::CZK) {
				if (empty($price->czk_member)) {
					$price = $price->czk;
				} else {
					$price = $price->czk_member;
				}
			} elseif ($currencyId === Currency::EUR) {
				$price = $price->eur;
			} elseif ($currencyId === Currency::CZK) {
				$price = $price->czk;
			}
			$sum += $price * $item['quantity'];
		}

		return [
			'price' => $sum,
			'currency' => Currency::whereId($currencyId)->first(),
		];
	}

}
