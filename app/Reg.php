<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reg
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Reg whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reg whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reg whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reg whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reg whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reg extends Model
{

	public function sports() {
		return $this->hasMany('App\RegSport');
	}

}
