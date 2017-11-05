<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Discipline
 *
 * @property int $id
 * @property string $name
 * @property int $item_id
 * @property int $status_id
 * @property int $sort_key
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discipline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discipline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discipline whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discipline whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discipline whereSortKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discipline whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discipline whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Discipline extends Model {

	static public function swimming() {
		return self::whereItemId(Item::SWIMMING)->orderBy('sort_key')->get();
	}

}
