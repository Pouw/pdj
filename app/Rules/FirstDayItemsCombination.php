<?php

namespace App\Rules;

use App\TournamentItem;
use Illuminate\Contracts\Validation\Rule;
use App\Item;

class FirstDayItemsCombination implements Rule {

	public function passes($attribute, $value) {
		$itemIds = [Item::BADMINTON, Item::SWIMMING, Item::SOCCER, Item::VOLLEYBALL];
		$tournamentItem = TournamentItem::whereIn('item_id', $itemIds)->whereHas('tournament', function ($query) {
			$query->where('status_id', 1);
		});
		$tournamentItemIds = $tournamentItem->get()->pluck('id')->all();
		$intersects = count(array_intersect($value, $tournamentItemIds));
		return ($intersects <= 1);
	}

	public function message() {
		return 'Badminton, Swimming and Volleyball take place in parallel. You can only participate in one of them.';
	}

}
