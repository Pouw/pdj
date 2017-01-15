
@include('sports/input/discipline_running', [
	'name' => 'running_discipline',
	'disciplines' => $regSport->sport->disciplines,
    'default' => $regSport->disciplines->count() > 0 ? $regSport->disciplines->first()->discipline_id : null,
])
