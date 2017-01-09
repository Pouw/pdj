
@include('form.team', [
	'name' => 'soccer_team',
	'title' => 'Team',
	'teams' => $regSport->sport->teams,
	'default' => $regSport->team_id,
])
