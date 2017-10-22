<table class="table table-hover">
	<thead>
	<tr>
		<th>ID</th>
		<th>State</th>
		<th>User</th>
		@if (in_array($sportId, [\App\Item::VOLLEYBALL, \App\Item::BEACH_VOLLEYBALL, \App\Item::SOCCER]))
			<th>Team Name</th>
		@endif
		@if (in_array($sportId, [\App\Item::VOLLEYBALL, \App\Item::BEACH_VOLLEYBALL]))
			<th>Level</th>
		@endif
		@if (in_array($sportId, [\App\Item::BEACH_VOLLEYBALL]))
			<th>Alt. Level</th>
		@endif
		@if (in_array($sportId, [\App\Item::RUNNING]))
			<th>Distance</th>
		@endif
		@if (in_array($sportId, [\App\Item::BADMINTON]))
			<th>Singles</th>
			<th>Doubles</th>
			<th>Partner Name</th>
			<th>Need Partner</th>
		@endif
		@if (in_array($sportId, [\App\Item::SWIMMING]))
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
	@foreach ($sportRegistrations as $sportReg)
		<tr>
			<td>
				<a href="{{ url('/admin/registration?id=' . $sportReg->registration->id) }}">#{{ $sportReg->registration->id }}</a>
			</td>
			<td class="{{ $sportReg->registration->state === \App\Registration::PAID ? 'success' : '' }}">{{ $sportReg->registration->state }}</td>
			<td>{{ $sportReg->registration->user->name }}</td>
			@if (in_array($sportId, [\App\Item::VOLLEYBALL]))
				<td>
					@if ($sportReg->team)
						{{ $sportReg->team->name }}
					@endif
				</td>
			@endif
			@if (in_array($sportId, [\App\Item::VOLLEYBALL]))
				<td>
					@if ($sportReg->team && $sportReg->team->level)
						{{ $sportReg->team->level->name }}
					@endif
				</td>
			@endif
			@if (in_array($sportId, [\App\Item::SOCCER]))
				<td>
					@if ($sportReg->team_id)
						{{ $sportReg->team->name }}
					@endif
				</td>
			@endif
			@if (in_array($sportId, [\App\Item::BEACH_VOLLEYBALL]))
				<td>{{ $sportReg->team_name }}</td>
				<td>
					@if ($sportReg->level)
						{{ $sportReg->level->name }}
					@endif
				</td>
				<td>
					@if ($sportReg->altLevel)
						{{ $sportReg->altLevel->name }}
					@endif
				</td>
			@endif
			@if (in_array($sportId, [\App\Item::BADMINTON]))
				<td>
					@if ($sportReg->level)
						{{ $sportReg->level->name }}
					@endif
				</td>
				<td>
					@if ($sportReg->altLevel)
						{{ $sportReg->altLevel->name }}
					@endif
				</td>
				<td>{{ $sportReg->team_name }}</td>
				<td>@if($sportReg->find_partner) Yes @endif</td>
			@endif
			@if (in_array($sportId, [\App\Item::RUNNING]))
				<td>
					@if ($sportReg->disciplines->count())
						{{ $sportReg->disciplines->first()->discipline->name }}
					@endif
				</td>
			@endif
			@if (in_array($sportId, [\App\Item::SWIMMING]))
				<td>{{ $sportReg->registration->user->birthdate }}</td>
				@foreach(\App\Discipline::swimming() as $discipline)
					<td>
						@if($sportReg->disciplines()->whereDisciplineId($discipline->id)->count()) Yes @endif
					</td>
				@endforeach
			@endif
			@if ($service === 'hosted_housing')
				<th>{{ $sportReg->registration->hh_from }}</th>
				<th>{{ $sportReg->registration->hh_to }}</th>
			@endif
			<td>
				@if($sportReg->registration->note)
					<span data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$sportReg->registration->note}}">
						<i class="fa fa-sticky-note"></i>
					</span>
				@endif
			</td>
			<td title="CZ Member">@if($sportReg->registration->user->is_member) <i class="fa fa-lg fa-user"></i> @endif</td>
			<td title="Brunch">@if($sportReg->registration->brunch) <i class="fa fa-lg fa-coffee"></i> @endif</td>
			<td title="Hosted Housing">@if($sportReg->registration->hosted_housing) <i class="fa fa-lg fa-bed"></i> @endif</td>
			<td title="Outreach Support">@if($sportReg->registration->outreach_support) <i class="fa fa-lg fa-eur support-color"></i> @endif</td>
			<td title="Outreach Request">@if($sportReg->registration->outreach_request) <i class="fa fa-lg fa-eur request-color"></i> @endif</td>
		</tr>
	@endforeach
	</tbody>
</table>
