<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Regs
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Regs whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Regs whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Regs whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Regs whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Regs whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Regs extends Model
{
    //
}
