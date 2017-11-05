<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Level
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort_key
 * @method static \Illuminate\Database\Query\Builder|\App\Level whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Level whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Level whereSortKey($value)
 * @mixin \Eloquent
 * @property int|null $item_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Level whereItemId($value)
 */
class Level extends Model
{
    const NO_PLAY = 14;
}
