
@include('sports/input/level', ['name' => 'badminton_level', 'title' => 'Level', 'levels' => $regSport->sport->levels])
@include('sports/input/discipline_badminton', ['name' => 'badminton_discipline', 'title' => 'Discipline', 'disciplines' => $regSport->sport->disciplines])
