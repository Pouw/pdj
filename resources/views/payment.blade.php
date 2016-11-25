@extends('layouts.app')

@section('content')
	@include('helper.panel_top')
	<div class="panel-heading">Payment</div>

	<div class="panel-body">

		<div class="col-md-3 col-md-offset-5">
			<p class="text-center">
				<span class="lead">Total Price:<br> {{ $totalPrice['price'] }} {{ $totalPrice['currency']->short }}</span>
			</p>
			<p class="text-center">
				<button type="button" class="btn btn-success btn-lg btn-block">
					<strong>Pay by Card</strong>
					<br>
					via<br>
					<img src="/img/gpwebpay.png">
				</button>
			</p>
		</div>
		<p></p>
		<p></p>
		@include('form.footer', ['back' => '/summary', 'next' => false])
	</div>

	@include('helper.panel_bottom')
@endsection
