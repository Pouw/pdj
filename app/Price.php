<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

	const BRUNCH = 7;
	const HOSTED_HOUSING = 8;
	const OUTREACH_SUPPORT = 11;

	static public function getOutreachSupportPrice() {
		return self::whereId(self::OUTREACH_SUPPORT)->first();
	}
}
