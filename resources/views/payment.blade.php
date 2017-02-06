@extends('layouts.app')

@section('content')
	@include('helper.panel_top')

	<div class="panel-heading">Payment</div>
	<div class="panel-body">

		@if (Auth::user()->registration->payments()->whereState(\App\Payments::PAID)->count() > 0)
			<p class="bg-success"></p>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="alert alert-success" role="alert">
						We register the following payments from you:
						<ul>
							@foreach(Auth::user()->registration->payments()->whereState(\App\Payments::PAID)->get() as $payment)
								<li>
									Amount: <strong>{{ $payment->amount }}</strong> {{ $payment->currency->iso }}
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<p></p>
		@else

			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="alert alert-info text-center" role="alert">
						<span style="font-size: 2em">
							Total Price:
							<span style="font-weight: bold;">{{ Auth::user()->registration->getPriceSummarize()->getTotalPrice() }} {{ Auth::user()->currency->iso }}</span>
						</span>
					</div>
				</div>
			</div>

			{{--<p class="text-center">--}}
				{{--<a href="{{ url('/payment-redirect') }}" class="btn btn-success btn-lg _btn-block">--}}
					{{--<strong>Pay by Card</strong>--}}
					{{--via--}}
					{{--<img src="/img/gpwebpay.png">--}}
				{{--</a>--}}
			{{--</p>--}}

			<p></p>

			@include('helper.bank_info')
		@endif

		@include('form.footer', ['back' => '/summary', 'next' => false])
	</div>

	@include('helper.panel_bottom')
@endsection
