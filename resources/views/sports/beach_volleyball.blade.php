<p>
	REMINDER: Each team member must register individually, filling in the same name of the team.
</p>

@include('form.text', ['name' => 'beach_volleyball_team_name', 'title' => 'Name of your team', 'default' => $registrationItem->team_name])
@include('sports/input/level', [
	'name' => 'beach_volleyball_level',
	'title' => 'Level',
	'levels' => $registrationItem->tournamentItem->item->levels,
	'default' => $registrationItem->level_id,
])
@include('sports/input/level', [
	'name' => 'beach_volleyball_alt_level',
	'title' => 'Alternative Level',
	'levels' => $registrationItem->tournamentItem->item->levels,
	'default' => $registrationItem->alt_level_id,
	'enableEmpty' => true,
])


