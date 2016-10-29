
@include('form.team', [
	'name' => 'volleyball_team',
	'title' => 'Team',
	'teams' => $regSport->sport->teams,
	'default' => $regSport->team_id,
	'levels' => $regSport->sport->levels,
])
@include('form.text', ['name' => 'volleyball_club', 'title' => 'Name of your club', 'default' => $regSport->club])
