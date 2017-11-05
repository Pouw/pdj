@extends('layouts.app')

@section('content')
	@include('helper.panel_top')

	<div class="panel-heading">Closed</div>

	<div class="panel-body">
		<p>Sorry, registrations for <b>19th Prague Rainbow Spring</b> are still closed.</p>
		<p>Come back later please.</p>
	</div>

	@include('helper.panel_bottom')
@endsection
