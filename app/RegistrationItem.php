<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * RegistrationItem
 *
 * @property integer $id
 * @property integer $reg_id
 * @property integer $sport_id
 * @property integer $level_id
 * @property integer $club_id
 * @property integer $team_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationItem whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationItem whereRegId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationItem whereSportId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationItem whereLevelId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationItem whereClubId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationItem whereTeamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RegistrationItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $registration_id
 * @property int $tournament_item_id
 * @property int|null $players
 * @property int|null $alt_level_id
 * @property string|null $club
 * @property string|null $team_name
 * @property string|null $captain
 * @property int|null $find_partner
 * @property-read \App\Level|null $altLevel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RegistrationItemDiscipline[] $disciplines
 * @property-read \App\Level|null $level
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Registration[] $registrations
 * @property-read \App\Team|null $team
 * @property-read \App\TournamentItem $tournamentItem
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItem whereAltLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItem whereCaptain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItem whereClub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItem whereFindPartner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItem wherePlayers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItem whereRegistrationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItem whereTeamName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RegistrationItem whereTournamentItemId($value)
 */
class RegistrationItem extends Model {

	public function registrations() {
		return $this->hasMany(Registration::class);
	}

//	public function item() {
//		return $this->belongsToMany(Item::class, 'tournament_items')->withPivot(['id', 'status_id']);
//	}

	public function tournamentItem() {
		return $this->belongsTo(TournamentItem::class);
	}

	public function disciplines() {
		return $this->hasMany(RegistrationItemDiscipline::class);
	}

	public function team() {
		return $this->belongsTo(Team::class);
	}

	public function level() {
		return $this->belongsTo(Level::class);
	}

	public function altLevel() {
		return $this->belongsTo(Level::class);
	}

}
