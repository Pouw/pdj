
@include('form.team', [
	'name' => 'volleyball_team',
	'title' => 'Team',
	'teams' => $registrationItem->tournamentItem->teams,
	'default' => $registrationItem->team_id,
	'levels' => $registrationItem->tournamentItem->item->levels,
])
@include('form.text', ['name' => 'volleyball_club', 'title' => 'Name of your club', 'default' => $registrationItem->club])
