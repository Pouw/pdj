
@include('sports/input/players', ['name' => 'volleyball_players', 'title' => 'Number of players'])
@include('sports/input/level', ['name' => 'volleyball_level', 'title' => 'Level', 'levels' => $regSport->sport->levels])
@include('sports/input/text', ['name' => 'volleyball_team', 'title' => 'Name of your team'])
@include('sports/input/text', ['name' => 'volleyball_club', 'title' => 'Name of your club'])