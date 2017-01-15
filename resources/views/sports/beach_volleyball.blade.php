<p>
	REMINDER: Each team member must register individually, filling in the same name of the team.
</p>

@include('form.text', ['name' => 'beach_volleyball_team_name', 'title' => 'Name of your team', 'default' => $regSport->team_name])
@include('sports/input/level', [
	'name' => 'beach_volleyball_level',
	'title' => 'Level',
	'levels' => $regSport->sport->levels,
	'default' => $regSport->level_id,
])
@include('sports/input/level', [
	'name' => 'beach_volleyball_alt_level',
	'title' => 'Alternative Level',
	'levels' => $regSport->sport->levels,
	'default' => $regSport->alt_level_id,
	'enableEmpty' => true,
])


