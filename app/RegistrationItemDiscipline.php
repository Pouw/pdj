<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RegistrationItemDiscipline
 *
 * @property int $id
 * @property int $registration_item_id
 * @property int $discipline_id
 * @property string|null $time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Discipline $discipline
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItemDiscipline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItemDiscipline whereDisciplineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItemDiscipline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItemDiscipline whereRegistrationItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItemDiscipline whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItemDiscipline whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RegistrationItemDiscipline extends Model
{
	public function discipline() {
		return $this->belongsTo(Discipline::class);
	}
}
