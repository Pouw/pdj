
@include('sports/input/discipline_running', [
	'name' => 'running_discipline',
	'disciplines' => $regSport->sport->disciplines,
    'default' => array_column($regSport->disciplines->toArray(), 'discipline_id'),
])
