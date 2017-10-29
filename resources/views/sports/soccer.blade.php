
@include('form.team', [
	'name' => 'football_team',
	'title' => 'Team',
	'teams' => $registrationItem->tournamentItem->item->teams,
	'default' => $registrationItem->team_id,
])
