<?php

namespace App\Libraries;

use App\Currency;
use App\Price;
use App\Registration;
use App\Sport;

class PriceSummarize {

	/** @var Registration */
	private $registration;

	public function __construct(Registration $registration)
	{
		$this->registration = $registration;
	}

	public function getTotalPrice() {
		$items = [];
		foreach ($this->registration->sports as $regSport) {
			$price = $regSport->sport->price;
			$items[] = [
				'price' => $price,
				'quantity' => 1,
			];
		}
		$sale = $this->getSale();
		if ($sale) {
			$items[] = [
				'price' => $sale,
				'quantity' => 1,
			];
		}
		if ($this->registration->brunch) {
			$items[] = [
				'price' => Price::getBrunchPrice(),
				'quantity' => 1,
			];
		}
		if ($this->registration->concert) {
			$items[] = [
				'price' => Price::getConcertTicketPrice(),
				'quantity' => 1,
			];
		}
		if ($this->registration->hosted_housing) {
			$items[] = [
				'price' => Price::getHostedHousingPrice(),
				'quantity' => 1,
			];
		}
		if ($this->registration->outreach_support) {
			$items[] = [
				'price' => Price::getOutreachSupportPrice(),
				'quantity' => intval($this->registration->outreach_support),
			];
		}

		$sum = 0;
		$currencyId = intval($this->registration->user->currency_id);
		foreach ($items as $item) {
			$price = $item['price'];
			if ($this->registration->user->is_member && $currencyId === Currency::CZK) {
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

		return $sum;
	}

	public function getSale() {
		$sportIds = [];
		$sale = false;
		foreach ($this->registration->sports as $regSport) {
			$sportIds[] = $regSport->sport->id;
		}
		if (count(array_intersect($sportIds, Sport::getMainSportIds()))) {
			if (in_array(Sport::BEACH_VOLLEYBALL, $sportIds)) {
				$sale = Price::getBeachVolleyballSale();
			} elseif (in_array(Sport::RUNNING, $sportIds)) {
				$sale = Price::getRunningSale();
			}
		}
		return $sale;
	}

}
