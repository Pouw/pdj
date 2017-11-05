<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Currency
 *
 * @property integer $id
 * @property string $iso
 * @property string $code
 * @property string $short
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Currency whereShort($value)
 * @mixin \Eloquent
 */
class Currency extends Model {
	const EUR = 1;
	const CZK = 2;
}
