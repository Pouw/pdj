
@include('sports/input/text', ['name' => 'swimming_club', 'title' => 'Name of your club'])
@include('sports/input/text', ['name' => 'swimming_captain', 'title' => 'Name of your captain'])


@foreach($regSport->sport->disciplines as $discipline)
	@include('sports/input/discipline_swimming', ['discipline' => $discipline, 'name' => 'discipline_' . $discipline->id])
@endforeach
