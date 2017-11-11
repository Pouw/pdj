<?php

namespace App\Libraries;

use App\Currency;
use App\Price;
use App\Registration;
use App\Item;

class PriceSummarize {

	/** @var Registration */
	private $registration;

	public function __construct(Registration $registration)
	{
		$this->registration = $registration;
	}

	public function getTotalPrice() {
		$items = [];
		foreach ($this->registration->registrationItems as $registrationItems) {
//			$price = $registrationItems->tournamentItem->price;
			$items[] = [
				'prices' => $this->registration->getPriceHelper()->getFinalPrices($registrationItems->tournamentItem->price_id),
				'quantity' => 1,
			];
		}
		$sale = $this->getSale();
		if ($sale) {
			$items[] = [
				'prices' => $sale,
				'quantity' => 1,
			];
		}
		if ($this->registration->brunch) {
			$items[] = [
				'prices' => $this->registration->getPriceHelper()->getFinalPrices(Price::BRUNCH),
				'quantity' => 1,
			];
		}
		if ($this->registration->concert) {
			$items[] = [
				'prices' => $this->registration->getPriceHelper()->getFinalPrices(Price::CONCERT_TICKET),
				'quantity' => 1,
			];
		}
		if ($this->registration->hosted_housing) {
			$items[] = [
				'prices' => $this->registration->getPriceHelper()->getFinalPrices(Price::HOSTED_HOUSING),
				'quantity' => 1,
			];
		}
		if ($this->registration->outreach_support) {
			$items[] = [
				'prices' => $this->registration->getPriceHelper()->getFinalPrices(Price::OUTREACH_SUPPORT, $this->registration->outreach_support),
				'quantity' => intval($this->registration->outreach_support),
			];
		}

		$eur = 0;
		$czk = 0;
		foreach ($items as $item) {
			if (isset($item['prices']['czk'])) {
				$czk += $item['prices']['czk'];
			}
			if (isset($item['prices']['eur'])) {
				$eur += $item['prices']['eur'];
			}
		}
		$prices = [];
		if ($czk > 0) {
			$prices['czk'] = $czk;
		}
		if ($eur > 0) {
			$prices['eur'] = $eur;
		}
		if ($this->registration->tournament->currency_id == Currency::CZK) {
			$prices['approx'] = true;
		}

		return $prices;
	}

	public function getSale() {
		$sportIds = [];
		$sale = false;
		foreach ($this->registration->registrationItems as $registrationItems) {
			$sportIds[] = $registrationItems->tournamentItem->id;
		}
		if (count(array_intersect($sportIds, Item::getMainSportIds()))) {
			if (in_array(Item::BEACH_VOLLEYBALL, $sportIds)) {
				$sale = Price::getBeachVolleyballSale();
			} elseif (in_array(Item::RUNNING, $sportIds)) {
				$sale = Price::getRunningSale();
			}
		}
		return $sale;
	}

}
