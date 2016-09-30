
@include('sports/input/level', ['name' => 'badminton_level', 'title' => 'Level', 'levels' => $regSport->sport->levels, 'default' => $regSport->level_id])
@include('sports/input/discipline_badminton', [
	'name' => 'badminton_discipline',
	'title' => 'Discipline',
	'disciplines' => $regSport->sport->disciplines,
	'default' => array_column($regSport->disciplines->toArray(), 'discipline_id'),
])
