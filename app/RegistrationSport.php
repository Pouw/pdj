<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RegSport
 *
 * @property integer $id
 * @property integer $reg_id
 * @property integer $sport_id
 * @property integer $level_id
 * @property integer $club_id
 * @property integer $team_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationSport whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationSport whereRegId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationSport whereSportId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationSport whereLevelId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationSport whereClubId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationSport whereTeamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationSport whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationSport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RegistrationSport extends Model
{

	public function sport() {
		return $this->belongsTo(\App\Sport::class);
	}

	public function disciplines() {
		return $this->hasMany(\App\RegistrationSportDisciplines::class);
	}

	public function team() {
		return $this->belongsTo(\App\Team::class);
	}

	public function level() {
		return $this->belongsTo(\App\Level::class);
	}

	public function altLevel() {
		return $this->belongsTo(\App\Level::class);
	}

}
