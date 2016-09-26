<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Sport
 *
 * @property integer $id
 * @property string $name
 * @property boolean $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Sport whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sport whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sport whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sport whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sport extends Model
{
    //
}
