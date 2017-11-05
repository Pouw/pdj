<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Status
 *
 * @mixin \Eloquent
 */
class Status extends Model
{
	const ACTIVE = 1;
	const DISABLED = 2;
}
