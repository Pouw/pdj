@extends('layouts.app')

@section('content')
	@include('helper.panel_top')

	<div class="panel-heading">Payment</div>

	<div class="panel-body">

		<div class="row">
			<div class="col-md-5 col-md-offset-3">
				<div class="alert alert-info text-center" role="alert">
					<span style="font-size: 2em">
						Total Price:
						<span style="font-weight: bold;">{{ Auth::user()->registration->getPriceSummarize()->getTotalPrice() }} {{ Auth::user()->currency->short }}</span>
					</span>
				</div>
			</div>
		</div>

			{{--
			<p class="text-center">
				<button type="button" class="btn btn-success btn-lg btn-block">
					<strong>Pay by Card</strong>
					<br>
					via<br>
					<img src="/img/gpwebpay.png">
				</button>
			</p>
			--}}
		<p></p>

		@include('helper.bank_info')

		@include('form.footer', ['back' => '/summary', 'next' => false])
	</div>

	@include('helper.panel_bottom')
@endsection
