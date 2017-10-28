<?php

namespace App\Rules;

use App\Item;
use App\TournamentItem;
use Illuminate\Contracts\Validation\Rule;

class VisitorOnly implements Rule {

	public function passes($attribute, $value) {
		$tournamentItem = TournamentItem::whereItemId(Item::VISITOR)->whereHas('tournament', function ($query) {
			$query->where('status_id', 1);
		});
		$tournamentItemVisitorId = $tournamentItem->get()->first()->id;
		if (!in_array($tournamentItemVisitorId, $value)) {
			return true;
		}
		return count($value) === 1;
	}

	public function message() {
		return 'You are not a visitor if you wish to participate';
	}
}
