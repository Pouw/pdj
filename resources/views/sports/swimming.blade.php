
@include('form.text', ['name' => 'swimming_club', 'title' => 'Name of your club', 'default' => $regSport->club])
@include('form.text', ['name' => 'swimming_captain', 'title' => 'Name of your captain', 'default' => $regSport->captain])


@foreach($regSport->sport->disciplines as $discipline)
	@include('sports/input/discipline_swimming', [
		'discipline' => $discipline,
		'id' => 'swimming_discipline_' . $discipline->id,
		'name' => 'swimming_discipline',
		'timeName' => 'swimming_discipline_time_' . $discipline->id,
		'default' => array_column($regSport->disciplines->toArray(), 'discipline_id'),
		'defaultTime' => $regSport->disciplines->where('discipline_id', $discipline->id)->count() ? $regSport->disciplines->where('discipline_id', $discipline->id)->first()->time : null,
	])
@endforeach
