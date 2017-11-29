<?php

namespace App\Libraries;

use App\Country;
use App\Currency;
use App\ExchangeRate;
use App\Price;
use App\Registration;

class PriceHelper {

	/** @var Registration */
	private $registration;

	public function __construct(Registration $registration) {
		$this->registration = $registration;
	}

	public function getFinalPrices($priceId, $multiplier = 1) {
		$price = Price::findOrFail($priceId);
		if ($this->registration->user->currency_id == Currency::CZK) {
			if ($this->registration->user->is_member && $price->czk_member) {
				return [
					'czk' => $price->czk_member * $multiplier
				];
			}
			if ($this->registration->user->country_id == Country::CZECHIA && $price->czk_local) {
				return [
					'czk' => $price->czk_local * $multiplier
				];
			}
			if ($price->czk) {
				return [
					'czk' => $price->czk * $multiplier
				];
			}
		}

		$tournamentCurrency = $this->registration->tournament->currency;
		if ($tournamentCurrency->id == Currency::CZK) {
			return [
				'czk' => $price->czk * $multiplier,
				'eur' => ExchangeRate::czkToEur($price->czk) * $multiplier,
				'approx' => true,
			];
		}
		if ($tournamentCurrency->id == Currency::EUR) {
			if ($this->registration->user->currency_id == Currency::EUR) {
				return [
					'eur' => $price->eur,
				];
			}
		}

		throw new \Error('PriceHelper can not getFinalPrices.');
	}



}
