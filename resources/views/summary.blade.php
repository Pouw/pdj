@extends('layouts.app')

@section('content')
@include('helper.panel_top')
<div class="panel-heading">Registration summary</div>

<div class="panel-body">

	<div class="row">
		<div class="table-responsive">
			<div class="col-md-10 col-md-offset-1">
			<table class="table">
				<thead>
				<tr>
					<th>Item</th>
					<th>Price</th>
				</tr>
				</thead>
				<tbody>
				@foreach($user->registration->sports as $regSport)
				<tr>
					<td>{{ $regSport->sport->id == \App\Sport::VISITOR ? 'Visitor' : $regSport->sport->name }}</td>
					<td>@include('helper.price', ['price' => $regSport->sport->price])</td>
				</tr>
				@endforeach
				@if ($user->registration->brunch)
				<tr>
					<td>Brunch</td>
					<td>@include('helper.price', ['price' => $price->getBrunchPrice()])</td>
				</tr>
				@endif
				@if ($user->registration->hosted_housing)
				<tr>
					<td>Hosted Housing</td>
					<td>@include('helper.price', ['price' => $price->getHostedHousingPrice()])</td>
				</tr>
				@endif
				@if ($user->registration->outreach_support)
				<tr>
					<td>Outreach Support</td>
					<td>
					@if ($user->currency_id === \App\Currency::CZK)
						{{ $price->getOutreachSupportPrice()->czk * $user->registration->outreach_support }} Kč
					@else
						{{ $price->getOutreachSupportPrice()->eur * $user->registration->outreach_support }} €
					@endif
					</td>
				</tr>
				@endif
				</tbody>
				<tfoot>
					<tr class="success">
						<th>Total Price</th>
						<th>{{ $totalPrice['price'] }} {{ $totalPrice['currency']->short }}</th>
					</tr>
				</tfoot>
			</table>
			</div>
		</div>
	</div>

	@include('form.footer', ['back' => '/service'])
</div>

@include('helper.panel_bottom')
@endsection
