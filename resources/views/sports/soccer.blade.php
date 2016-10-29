
@include('form.team', [
	'name' => 'soccer_team',
	'title' => 'Team',
	'teams' => $regSport->sport->teams,
	'default' => $regSport->team_id,
	'levels' => $regSport->sport->levels,
])
@include('form.text', ['name' => 'soccer_club', 'title' => 'Name of your club', 'default' => $regSport->club])
