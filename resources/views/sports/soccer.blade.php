
@include('form.team', [
	'name' => 'football_team',
	'title' => 'Team',
	'teams' => $regSport->sport->teams,
	'default' => $regSport->team_id,
])
