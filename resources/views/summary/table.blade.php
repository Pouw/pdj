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
	@foreach($registration->registrationItems as $registrationItem)
		<tr>
			@if ($registrationItem->tournamentItem->item_id == \App\Item::VISITOR)
				<td>
					Visitor<br>
					<small>Includes public transport and party tickets.</small>
				</td>
			@else
				<td>
					{{ $registrationItem->tournamentItem->item->name }}
					@if ($registrationItem->tournamentItem->item->title || in_array($registrationItem->tournamentItem->item->id, [
					App\Item::RUNNING,
					App\Item::SOCCER,
					App\Item::VOLLEYBALL,
					App\Item::BEACH_VOLLEYBALL,
					App\Item::BADMINTON,
					App\Item::SWIMMING]))
						<ul style="font-size: 0.9em; margin-bottom: 0; margin-top: 0">
							@if ($registrationItem->tournamentItem->item->title)
								<li>{{ $registrationItem->tournamentItem->item->title }}</li>
							@endif
							@if ($registrationItem->tournamentItem->item_id == App\Item::RUNNING)
								<li>Distance: {{ $registrationItem->disciplines->count() ? $registrationItem->disciplines->first()->discipline->name : '' }}</li>
							@endif
							@if ($registrationItem->tournamentItem->item_id == App\Item::SOCCER)
								@if($registrationItem->team)
									<li>Team name: {{ $registrationItem->team->name }}</li>
								@endif
							@endif
							@if ($registrationItem->tournamentItem->item_id == App\Item::VOLLEYBALL)
								@if($registrationItem->team)
									<li>Team: {{ $registrationItem->team->name }}</li>
									<li>Level: {{$registrationItem->team->level->name}}</li>
								@endif
								@if($registrationItem->club)
									<li>Club: {{ $registrationItem->club }}</li>
								@endif
							@endif
							@if ($registrationItem->tournamentItem->item_id == App\Item::BEACH_VOLLEYBALL)
								<li>Team name: {{ $registrationItem->team_name }}</li>
								@if ($registrationItem->level)
									<li>Level: {{ $registrationItem->level->name }}</li>
								@endif
								@if ($registrationItem->altLevel)
									<li>Alternative level: {{ $registrationItem->altLevel->name }}</li>
								@endif
							@endif
							@if ($registrationItem->tournamentItem->item_id == App\Item::SWIMMING)
								<li>Club: {{ $registrationItem->club }}</li>
								<li>Captain: {{ $registrationItem->captain }}</li>
								<li>
									Disciplines:
									<ul style="margin-bottom: 0; margin-top: 0">
										@foreach($registrationItem->disciplines as $discipline)
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
							@if ($registrationItem->tournamentItem->item_id == App\Item::BADMINTON)
								<li>
									Category: {{ $registrationItem->disciplines->count() ? $registrationItem->disciplines->first()->discipline->name : ''}}</li>
								<li>Singles: {{ $registrationItem->level_id ? $registrationItem->level->name : ''}}</li>
								<li>Doubles: {{ $registrationItem->altLevel ? $registrationItem->altLevel->name : '' }}</li>
								<li>Your
									partner: {{ $registrationItem->find_partner ? 'Need to find' : $registrationItem->team_name }}</li>
							@endif
						</ul>
					@endif
				</td>
			@endif
			<td align="right">
				@include('helper.price', ['prices' => $registration->getPriceHelper()->getFinalPrices($registrationItem->tournamentItem->price_id)])
			</td>
		</tr>
	@endforeach

	@if ($registration->brunch)
		<tr>
			<td>Brunch</td>
			<td align="right">
				@include('helper.price', ['prices' => $registration->getPriceHelper()->getFinalPrices(\App\Price::BRUNCH)])
			</td>
		</tr>
	@endif

	@if ($registration->concert)
		<tr>
			<td>Concert Doodles and Podium Paris ticket</td>
			<td align="right">
				@include('helper.price', ['prices' => $registration->getPriceHelper()->getFinalPrices(\App\Price::CONCERT_TICKET)])
			</td>
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
			<td align="right">
				@include('helper.price', ['prices' => $registration->getPriceHelper()->getFinalPrices(\App\Price::HOSTED_HOUSING)])
			</td>
		</tr>
	@endif

	@if ($registration->outreach_support)
		<tr>
			<td>Outreach Support</td>
			<td align="right">
				@include('helper.price', ['prices' => $registration->getPriceHelper()->getFinalPrices(\App\Price::OUTREACH_SUPPORT, $registration->outreach_support)])
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
			<td align="right">@include('helper.price', [
				'prices' => $registration->getPriceHelper()->getFinalPrices($registration->getPriceSummarize()->getSale()->id
				)])
			</td>
		</tr>
	@endif

	</tbody>
	<tfoot>
	<tr class="success">
		<th align="left">Total Price</th>
		<th align="right">
			@include('helper.price', ['prices' => $registration->getPriceSummarize()->getTotalPrice()])
		</th>
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
