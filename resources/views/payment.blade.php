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
						<span style="font-weight: bold;">{{ $totalPrice['price'] }} {{ $totalPrice['currency']->short }}</span>
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
		<h2>Bank transfer information:</h2>
		<dl class="dl-horizontal">
		@if (intval($user->currency_id) === \App\Currency::CZK)
			<dt>Bank account:</dt>
			<dd>2001064718/2010</dd>
			<dt>Variable symbol:</dt>
			<dd>{{ $user->registration->variableSymbol() }}</dd>
		@else
			<dt>Payee's name:</dt>
			<dd>Alcedo Praha, z.s.</dd>
			<dt>Payee's country:</dt>
			<dd>Czech Republic or Czechia</dd>
			<dt>Bank name:</dt>
			<dd>Fio banka, a.s.</dd>
			<dt>Bank address:</dt>
			<dd>V Celnici 1028/10, 117 21 Praha 1</dd>

			<dt>IBAN:</dt>
			<dd>CZ04 2010 0000 0020 0106 4718</dd>
			<dt>BIC (SWIFT):</dt>
			<dd>FIOBCZPPXXX</dd>
			<dt>Purpose:</dt>
			<dd>{{ $user->registration->paymentPurpose() }}</dd>
		@endif
		</dl>

		<div class="alert alert-warning" role="alert">
			We are now working on online payment, so you can come back later and pay online by card.
		</div>

		@include('form.footer', ['back' => '/summary', 'next' => false])
	</div>

	@include('helper.panel_bottom')
@endsection
