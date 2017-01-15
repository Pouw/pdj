@extends('layouts.app')

@section('content')
	@include('helper.panel_top')
	<div class="panel-heading">Registration summary</div>

	<div class="panel-body">

		<div class="row">
			<div class="table-responsive">
				<div class="col-md-10 col-md-offset-1">
					<table class="table summary">
						<thead>
						<tr>
							<th>Item</th>
							<th>Price</th>
						</tr>
						</thead>
						<tbody>
						@foreach($user->registration->sports as $regSport)
							<tr>
								@if ($regSport->sport->id == \App\Sport::VISITOR)
									<td>
										Visitor<br>
										<small>Includes public transport and party tickets.</small>
									</td>
								@else
									<td>
										{{ $regSport->sport->name }}
										@if ($regSport->sport->title || in_array($regSport->sport->id, [App\Sport::RUNNING, App\Sport::SOCCER, App\Sport::VOLLEYBALL, App\Sport::BEACH_VOLLEYBALL, App\Sport::SWIMMING]))
											<ul style="font-size: 0.9em">
												@if ($regSport->sport->title)
													<li>{{ $regSport->sport->title }}</li>
												@endif
												@if ($regSport->sport->id == App\Sport::RUNNING)
													<li>
														Distance: {{ $regSport->disciplines->first()->discipline->name }}</li>
												@endif
												@if ($regSport->sport->id == App\Sport::SOCCER)
													<li>Team name: {{ $regSport->team->name }}</li>
												@endif
												@if ($regSport->sport->id == App\Sport::VOLLEYBALL)
													<li>Team: {{ $regSport->team->name }}
														<small>( {{$regSport->team->level->name}})</small>
													</li>
												@endif
												@if ($regSport->sport->id == App\Sport::BEACH_VOLLEYBALL)
													<li>Team name: {{ $regSport->team_name }}</li>
													<li>Level: {{ $regSport->level->name }}</li>
													@if ($regSport->altLevel)
														<li>Alternative level: {{ $regSport->altLevel->name }}</li>
													@endif
												@endif
												@if ($regSport->sport->id == App\Sport::SWIMMING)
													<li>Club: {{ $regSport->club }}</li>
													<li>Captain: {{ $regSport->captain }}</li>
													<li>
														Disciplines:
														<ul>
															@foreach($regSport->disciplines as $discipline)
																<li>
																	{{ $discipline->discipline->name }}
																	@if ($discipline->time)
																		({{ $discipline->time }})
																	@endif
																</li>
															@endforeach
														</ul>
													</li>
												@endif
											</ul>
										@endif
									</td>
								@endif
								<td>@include('helper.price', ['price' => $regSport->sport->price])</td>
							</tr>
						@endforeach

						@if ($user->registration->brunch)
							<tr>
								<td>Brunch</td>
								<td>@include('helper.price', ['price' => $price->getBrunchPrice()])</td>
							</tr>
						@endif

						@if ($user->registration->concert)
							<tr>
								<td>Concert Doodles and Podium Paris ticket</td>
								<td>@include('helper.price', ['price' => $price->getConcertTicketPrice()])</td>
							</tr>
						@endif

						@if ($user->registration->hosted_housing)
							<tr>
								<td>
									Hosted Housing
									<ul style="font-size: 0.9em">
										<li>From: {{ $user->registration->hh_from }}</li>
										<li>To: {{ $user->registration->hh_to }}</li>
									</ul>
								</td>
								<td>@include('helper.price', ['price' => $price->getHostedHousingPrice()])</td>
							</tr>
						@endif

						@if ($user->registration->outreach_support)
							<tr>
								<td>Outreach Support</td>
								<td>
									@if (intval($user->currency_id) === \App\Currency::CZK)
										{{ $price->getOutreachSupportPrice()->czk * $user->registration->outreach_support }}
										&nbsp;Kč
									@else
										{{ $price->getOutreachSupportPrice()->eur * $user->registration->outreach_support }}
										&nbsp;€
									@endif
								</td>
							</tr>
						@endif

						@if ($sale)
							<tr>
								<td>
									{{ $sale->name }}
									<ul style="font-size: 0.9em">
										<li>Discount for second sport.</li>
									</ul>
								</td>
								<td>@include('helper.price', ['price' => $sale])</td>
							</tr>
						@endif

						</tbody>
						<tfoot>
						<tr class="success">
							<th>Total Price</th>
							<th>{{ $totalPrice['price'] }}&nbsp;{{ $totalPrice['currency']->short }}</th>
						</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<form role="form" method="POST">
			{{ csrf_field() }}
			@include('form.footer', ['back' => '/service'])
		</form>
	</div>

	@include('helper.panel_bottom')
@endsection
