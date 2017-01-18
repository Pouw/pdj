<?php

namespace App\Libraries;

use App\Currency;
use App\Price;
use App\Sport;
use App\User;
use Illuminate\Support\Facades\Auth;

class PriceSummarize {

	private $user = null;

	public function getUser(): User {
		if ($this->user !== null) {
			return $this->user;
		}
		return Auth::user();
	}

	public function setUser(User $user) {
		$this->user = $user;
		return $this;
	}

	public function getTotalPrice() {
		$user = $this->getUser();
		$items = [];
		foreach ($user->registration->sports as $regSport) {
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
		if ($user->registration->brunch) {
			$items[] = [
				'price' => Price::getBrunchPrice(),
				'quantity' => 1,
			];
		}
		if ($user->registration->concert) {
			$items[] = [
				'price' => Price::getConcertTicketPrice(),
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

	public function getSale() {
		$user = $this->getUser();
		$sportIds = [];
		$sale = false;
		foreach ($user->registration->sports as $regSport) {
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
