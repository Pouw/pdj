<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationStatus extends Model
{
	const UNFINISHED = 1;
	const NEW = 2;
	const PAID = 3;
	const CANCELED = 4;
}
