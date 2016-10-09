
@include('form.persons', ['name' => 'volleyball_players', 'title' => 'Number of players', 'default' => $regSport->players])
@include('sports.input.level', ['name' => 'volleyball_level', 'title' => 'Level', 'levels' => $regSport->sport->levels, 'default' => $regSport->level_id])
@include('sports.input.text', ['name' => 'volleyball_team', 'title' => 'Name of your team', 'default' => $regSport->team])
@include('sports.input.text', ['name' => 'volleyball_club', 'title' => 'Name of your club', 'default' => $regSport->club])