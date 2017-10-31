<table class="table table-hover">
	<thead>
	<tr>
		<th>ID</th>
		<th>State</th>
		<th>User</th>
		@if (in_array($itemId, [\App\Item::VOLLEYBALL, \App\Item::BEACH_VOLLEYBALL, \App\Item::SOCCER]))
			<th>Team Name</th>
		@endif
		@if (in_array($itemId, [\App\Item::VOLLEYBALL, \App\Item::BEACH_VOLLEYBALL]))
			<th>Level</th>
		@endif
		@if (in_array($itemId, [\App\Item::BEACH_VOLLEYBALL]))
			<th>Alt. Level</th>
		@endif
		@if (in_array($itemId, [\App\Item::RUNNING]))
			<th>Distance</th>
		@endif
		@if (in_array($itemId, [\App\Item::BADMINTON]))
			<th>Singles</th>
			<th>Doubles</th>
			<th>Partner Name</th>
			<th>Need Partner</th>
		@endif
		@if (in_array($itemId, [\App\Item::SWIMMING]))
			<th>Birthdate</th>
			@foreach(\App\Discipline::swimming() as $i => $discipline)
				<th title="{{ $discipline->name }}">{{ $i + 1 }}.</th>
			@endforeach
		@endif
		@if ($service === 'hosted_housing')
			<th title="Hosted Housing From">HH From</th>
			<th title="Hosted Housing To">HH To</th>
		@endif
		<th title="User Note"><i class="fa fa-sticky-note"></i></th>
		<th title="CZ Member"><i class="fa fa-lg fa-user"></i></th>
		<th title="Brunch"><i class="fa fa-lg fa-coffee"></i></th>
		<th title="Hosted Housing"><i class="fa fa-lg fa-bed"></i></th>
		<th title="Outreach Support"><i class="fa fa-lg fa-eur support-color"></i></th>
		<th title="Outreach Request"><i class="fa fa-lg fa-eur request-color"></i></th>
	</tr>
	</thead>
	<tbody>
	@foreach ($registrations as $registration)
		<tr>
			<td>
				<a href="{{ url('/admin/registration/id/' . $registration->id) }}">#{{ $registration->id }}</a>
			</td>
			<td class="{{ $registration->state === \App\Registration::PAID ? 'success' : '' }}">{{ $registration->state }}</td>
			<td>{{ $registration->user->name }}</td>
			@foreach ($registration->registrationItems as $registrationItem)
				@if (in_array($itemId, [\App\Item::VOLLEYBALL]) && $registrationItem->tournamentItem->item_id == $itemId)
					<td>
						@if ($registrationItem->team)
							{{ $registrationItem->team->name }}
						@endif
					</td>
				@endif
				@if (in_array($itemId, [\App\Item::VOLLEYBALL]) && $registrationItem->tournamentItem->item_id == $itemId)
					<td>
						@if ($registrationItem->team && $registrationItem->team->level)
							{{ $registrationItem->team->level->name }}
						@endif
					</td>
				@endif
				@if (in_array($itemId, [\App\Item::SOCCER]) && $registrationItem->tournamentItem->item_id == $itemId)
					<td>
						@if ($registrationItem->team_id)
							{{ $registrationItem->team->name }}
						@endif
					</td>
				@endif
				@if (in_array($itemId, [\App\Item::BEACH_VOLLEYBALL]) && $registrationItem->tournamentItem->item_id == $itemId)
					<td>{{ $registrationItem->team_name }}</td>
					<td>
						@if ($registrationItem->level)
							{{ $registrationItem->level->name }}
						@endif
					</td>
					<td>
						@if ($registrationItem->altLevel)
							{{ $registrationItem->altLevel->name }}
						@endif
					</td>
				@endif
				@if (in_array($itemId, [\App\Item::BADMINTON]) && $registrationItem->tournamentItem->item_id == $itemId)
					<td>
						@if ($registrationItem->level)
							{{ $registrationItem->level->name }}
						@endif
					</td>
					<td>
						@if ($registrationItem->altLevel)
							{{ $registrationItem->altLevel->name }}
						@endif
					</td>
					<td>{{ $registrationItem->team_name }}</td>
					<td>@if($registrationItem->find_partner) Yes @endif</td>
				@endif
				@if (in_array($itemId, [\App\Item::RUNNING]) && $registrationItem->tournamentItem->item_id == $itemId)
					<td>
						@if ($registrationItem->disciplines->count())
							{{ $registrationItem->disciplines->first()->discipline->name }}
						@endif
					</td>
				@endif
				@if (in_array($itemId, [\App\Item::SWIMMING]) && $registrationItem->tournamentItem->item_id == $itemId)
					<td>{{ $registration->user->birthdate }}</td>
					@foreach(\App\Discipline::swimming() as $discipline)
						<td>
							@if($registrationItem->disciplines()->whereDisciplineId($discipline->id)->count()) Yes @endif
						</td>
					@endforeach
				@endif
			@endforeach
			@if ($service === 'hosted_housing')
				<th>{{ $registration->hh_from }}</th>
				<th>{{ $registration->hh_to }}</th>
			@endif
			<td>
				@if($registration->note)
					<span data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$registration->note}}">
						<i class="fa fa-sticky-note"></i>
					</span>
				@endif
			</td>
			<td title="CZ Member">@if($registration->user->is_member) <i class="fa fa-lg fa-user"></i> @endif</td>
			<td title="Brunch">@if($registration->brunch) <i class="fa fa-lg fa-coffee"></i> @endif</td>
			<td title="Hosted Housing">@if($registration->hosted_housing) <i class="fa fa-lg fa-bed"></i> @endif</td>
			<td title="Outreach Support">@if($registration->outreach_support) <i class="fa fa-lg fa-eur support-color"></i> @endif</td>
			<td title="Outreach Request">@if($registration->outreach_request) <i class="fa fa-lg fa-eur request-color"></i> @endif</td>
		</tr>
	@endforeach
	</tbody>
</table>
