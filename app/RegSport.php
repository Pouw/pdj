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
 * @method static \Illuminate\Database\Query\Builder|\App\RegSport whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegSport whereRegId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegSport whereSportId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegSport whereLevelId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegSport whereClubId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegSport whereTeamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegSport whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegSport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RegSport extends Model
{
    //
}
