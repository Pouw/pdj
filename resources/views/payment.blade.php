@extends('layouts.app')

@section('content')
	@include('helper.panel_top')

	<div class="panel-heading">Payment</div>
	<div class="panel-body">

		@if ($registration->payments()->whereState(\App\Payments::PAID)->count() > 0)
			<div class="row space">
				<div class="col-md-offset-2 col-md-8">
					<div class="alert alert-success" role="alert">
						We register the following payments from you:
						<ul>
							@foreach($registration->payments()->whereState(\App\Payments::PAID)->get() as $payment)
								<li>
									Amount: <strong>{{ $payment->amount }}</strong> {{ $payment->currency->iso }}
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<p></p>
		@endif


		@if ($registration->getAmountsForPay()[\App\Currency::CZK] > 0)

			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="alert alert-info text-center" role="alert">
						<span style="font-size: 1.5em">
							Need to pay:
							<span style="font-weight: bold;">{{ $registration->getAmountsForPay()[$registration->user->currency_id] }} {{ $registration->user->currency->iso }}</span>
						</span>
					</div>
				</div>
			</div>

			<p class="text-center">
				<a href="{{ url('/payment/redirect') }}" class="btn btn-success btn-lg">
					<i class="fa fa-lg fa-credit-card"></i>
					Pay online
					<b>{{ $registration->getAmountsForPay()[\App\Currency::CZK] }} CZK</b>
					{{--<i class="fa fa-cc-visa"></i>--}}
					{{--<i class="fa fa-cc-mastercard"></i>--}}
				</a>
			</p>

			@include('helper.bank_info')
		@endif

		@include('form.footer', ['back' => '/summary', 'next' => false])
	</div>

	@include('helper.panel_bottom')
@endsection
