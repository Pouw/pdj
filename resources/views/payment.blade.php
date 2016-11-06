@extends('layouts.app')

@section('content')
	@include('helper.panel_top')
	<div class="panel-heading">Payment</div>

	<div class="panel-body">

		<div class="row">
			<h2>Total Price: {{ $totalPrice['price'] }} {{ $totalPrice['currency']->short }}</h2>
		</div>

		@include('form.footer', ['back' => '/summary'])
	</div>

	@include('helper.panel_bottom')
@endsection
