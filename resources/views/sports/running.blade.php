
@include('sports/input/discipline_running', [
	'name' => 'running_discipline',
	'disciplines' => $registrationItem->tournamentItem->item->disciplines,
    'default' => $registrationItem->disciplines->count() > 0 ? $registrationItem->disciplines->first()->discipline_id : null,
])
