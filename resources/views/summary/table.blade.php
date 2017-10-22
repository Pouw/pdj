<table class="table summary" width="100%"
	   border="{{ $isMail ? 1 : 0 }}"
	   {{ $isMail ? 'bordercolor="#ddd"' : '' }}
	   cellspacing="0"
	   cellpadding="{{ $isMail ? 10 : 0 }}"
	   style="border-collapse: collapse">
	<thead>
	<tr>
		<th align="left">Item</th>
		<th align="right">Price</th>
	</tr>
	</thead>
	<tbody>
	@foreach($registration->sports as $regSport)
		<tr>
			@if ($regSport->sport->id == \App\Item::VISITOR)
				<td>
					Visitor<br>
					<small>Includes public transport and party tickets.</small>
				</td>
			@else
				<td>
					{{ $regSport->sport->name }}
					@if ($regSport->sport->title || in_array($regSport->sport->id, [
					App\Item::RUNNING,
					App\Item::SOCCER,
					App\Item::VOLLEYBALL,
					App\Item::BEACH_VOLLEYBALL,
					App\Item::BADMINTON,
					App\Item::SWIMMING]))
						<ul style="font-size: 0.9em; margin-bottom: 0; margin-top: 0">
							@if ($regSport->sport->title)
								<li>{{ $regSport->sport->title }}</li>
							@endif
							@if ($regSport->sport->id == App\Item::RUNNING)
								<li>Distance: {{ $regSport->disciplines->count() ? $regSport->disciplines->first()->discipline->name : '' }}</li>
							@endif
							@if ($regSport->sport->id == App\Item::SOCCER)
								@if($regSport->team)
									<li>Team name: {{ $regSport->team->name }}</li>
								@endif
							@endif
							@if ($regSport->sport->id == App\Item::VOLLEYBALL)
								@if($regSport->team)
									<li>Team: {{ $regSport->team->name }}</li>
									<li>Level: {{$regSport->team->level->name}}</li>
								@endif
								@if($regSport->club)
									<li>Club: {{ $regSport->club }}</li>
								@endif
							@endif
							@if ($regSport->sport->id == App\Item::BEACH_VOLLEYBALL)
								<li>Team name: {{ $regSport->team_name }}</li>
								@if ($regSport->level)
									<li>Level: {{ $regSport->level->name }}</li>
								@endif
								@if ($regSport->altLevel)
									<li>Alternative level: {{ $regSport->altLevel->name }}</li>
								@endif
							@endif
							@if ($regSport->sport->id == App\Item::SWIMMING)
								<li>Club: {{ $regSport->club }}</li>
								<li>Captain: {{ $regSport->captain }}</li>
								<li>
									Disciplines:
									<ul style="margin-bottom: 0; margin-top: 0">
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
							@if ($regSport->sport->id == App\Item::BADMINTON)
								<li>
									Category: {{ $regSport->disciplines->count() ? $regSport->disciplines->first()->discipline->name : ''}}</li>
								<li>Singles: {{ $regSport->level_id ? $regSport->level->name : ''}}</li>
								<li>Doubles: {{ $regSport->altLevel ? $regSport->altLevel->name : '' }}</li>
								<li>Your
									partner: {{ $regSport->find_partner ? 'Need to find' : $regSport->team_name }}</li>
							@endif
						</ul>
					@endif
				</td>
			@endif
			<td align="right">@include('helper.price', ['price' => $regSport->sport->price, 'user' => $registration->user])</td>
		</tr>
	@endforeach

	@if ($registration->brunch)
		<tr>
			<td>Brunch</td>
			<td align="right">@include('helper.price', ['price' => $price->getBrunchPrice(), 'user' => $registration->user])</td>
		</tr>
	@endif

	@if ($registration->concert)
		<tr>
			<td>Concert Doodles and Podium Paris ticket</td>
			<td align="right">@include('helper.price', ['price' => $price->getConcertTicketPrice(), 'user' => $registration->user])</td>
		</tr>
	@endif

	@if ($registration->hosted_housing)
		<tr>
			<td>
				Hosted Housing
				<ul style="font-size: 0.9em; margin-bottom: 0; margin-top: 0">
					<li>From: {{ $registration->hh_from }}</li>
					<li>To: {{ $registration->hh_to }}</li>
				</ul>
			</td>
			<td align="right">@include('helper.price', ['price' => $price->getHostedHousingPrice(), 'user' => $registration->user])</td>
		</tr>
	@endif

	@if ($registration->outreach_support)
		<tr>
			<td>Outreach Support</td>
			<td align="right">
				@if (intval($registration->user->currency_id) === \App\Currency::CZK)
					{{ $price->getOutreachSupportPrice()->czk * $registration->outreach_support }}&nbsp;Kč
				@else
					{{ $price->getOutreachSupportPrice()->eur * $registration->outreach_support }}&nbsp;€
				@endif
			</td>
		</tr>
	@endif

	@if ($registration->getPriceSummarize()->getSale())
		<tr>
			<td>
				{{ $registration->getPriceSummarize()->getSale()->name }}
				<ul style="font-size: 0.9em; margin-bottom: 0; margin-top: 0">
					<li>Discount for second sport.</li>
				</ul>
			</td>
			<td align="right">@include('helper.price', ['price' => $registration->getPriceSummarize()->getSale(), 'user' => $registration->user])</td>
		</tr>
	@endif

	</tbody>
	<tfoot>
	<tr class="success">
		<th align="left">Total Price</th>
		<th align="right">{{ $registration->getPriceSummarize()->getTotalPrice() }}&nbsp;{{ $registration->user->currency->short }}</th>
	</tr>
	</tfoot>
</table>
@if ($registration->note)
	<p class="player-note">
		<strong>Your Comments:</strong><br>
		{!! nl2br(e($registration->note)) !!}
	</p>
	@if ($isMail)
		<hr>
	@endif
@endif
