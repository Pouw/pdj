
@include('form.text', ['name' => 'swimming_club', 'title' => 'Name of your club', 'default' => $registrationItem->club])
@include('form.text', ['name' => 'swimming_captain', 'title' => 'Name of your captain', 'default' => $registrationItem->captain])



@foreach($registrationItem->tournamentItem->item->disciplines->sortBy('sort_key') as $discipline)
	@include('sports/input/discipline_swimming', [
		'discipline' => $discipline,
		'id' => 'swimming_discipline_' . $discipline->id,
		'name' => 'swimming_discipline',
		'timeName' => 'swimming_discipline_time_' . $discipline->id,
		'default' => array_column($registrationItem->disciplines->toArray(), 'discipline_id'),
		'defaultTime' => $registrationItem->disciplines()->whereDisciplineId($discipline->id)->count() ? $registrationItem->disciplines()->whereDisciplineId($discipline->id)->first()->time : null,
	])
@endforeach
