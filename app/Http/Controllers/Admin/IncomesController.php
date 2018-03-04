<?php

namespace App\Http\Controllers\Admin;

use App\Price;
use App\Registration;
use App\Tournament;
use Illuminate\Http\Request;

class IncomesController extends Controller {
	
	public function index(Request $request) {
		$tournamentId = $this->getTournamentId();
		$tournament = Tournament::findOrFail($tournamentId);
		$incomes = [
			'brunch' => [
				'name' => 'Brunch',
				'quantity' => 0,
				'czk' => 0,
				'sale_czk' => 0,
				'outreach_czk' => 0,
			],
			'concert' => [
				'name' => 'Concert',
				'quantity' => 0,
				'czk' => 0,
				'sale_czk' => 0,
				'outreach_czk' => 0,
			],
			'hosted_housing' => [
				'name' => 'Hosted Housing',
				'quantity' => 0,
				'czk' => 0,
				'sale_czk' => 0,
				'outreach_czk' => 0,
			],
		];
		$registrations = 0;
		foreach ($tournament->registrations as $registration) {
			if ($registration->state === Registration::PAID) {
				$registrations++;
				$registrationSale = $registration->getSale();
				$registrationItems = $registration->registrationItems;
				$sale = 0;
				if ($registrationSale) {
					$sale = $registrationSale['czk'] / $registrationItems->count();
				}

				$outreach = 0;
				if ($registration->outreach_support) {
					$outreach = $registration->getPriceHelper()->getFinalPrices(Price::OUTREACH_SUPPORT, $registration->outreach_support);
					$outreach = $outreach['czk'] / $registrationItems->count();
				}

				foreach ($registrationItems as $registrationItem) {
					$itemId = $registrationItem->tournamentItem->item->id;
					if (!isset($incomes[$itemId])) {
						$incomes[$itemId] = [
							'name' => $registrationItem->tournamentItem->item->name,
							'quantity' => 0,
							'czk' => 0,
							'sale_czk' => 0,
							'outreach_czk' => 0,
						];
					}

					$price = $registration->getPriceHelper()->getFinalPrices($registrationItem->tournamentItem->price_id);
					$incomes[$itemId]['quantity']++;
					$incomes[$itemId]['czk'] += $price['czk'];
					$incomes[$itemId]['sale_czk'] += $sale;
					$incomes[$itemId]['outreach_czk'] += $outreach;
				}
				
				if ($registration->brunch) {
					$incomes['brunch']['czk'] += $registration->getPriceHelper()->getFinalPrices(Price::BRUNCH)['czk'];
					$incomes['brunch']['quantity']++;
				}
				if ($registration->concert) {
					$incomes['concert']['czk'] += $registration->getPriceHelper()->getFinalPrices(Price::CONCERT_TICKET)['czk'];
					$incomes['concert']['quantity']++;
				}
				if ($registration->hosted_housing) {
					$incomes['hosted_housing']['czk'] += $registration->getPriceHelper()->getFinalPrices(Price::HOSTED_HOUSING)['czk'];
					$incomes['hosted_housing']['quantity']++;
				}
			}
		}
		$sum = [
			'name' => 'Summary',
			'quantity' => $registrations,
			'czk' => 0,
			'sale_czk' => 0,
			'outreach_czk' => 0,
			'sum' => 0,
		];
		foreach ($incomes as &$income) {
			$income['sum'] = $income['czk'] + $income['sale_czk'];
			$sum['czk'] += $income['czk'];
			$sum['sale_czk'] += $income['sale_czk'];
			$sum['outreach_czk'] += $income['outreach_czk'];
			$sum['sum'] += $income['sum'];
		}
		$incomes['sum'] = $sum;
		$data = [
			'incomes' => $incomes,
		];
		return view('admin.incomes.index', $data);
	}

}
