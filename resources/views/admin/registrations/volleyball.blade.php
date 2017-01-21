<table class="table">
	<thead>
	<tr>
		<th>ID</th>
		<th>State</th>
		<th>User</th>
		<th>Team</th>
		<th>Level</th>
		<th>Note</th>
	</tr>
	</thead>
	<tbody>
	@foreach ($sportRegistrations as $sportReg)
	<tr>
		<td>
			<a href="{{ url('/admin/registration?id=' . $sportReg->registration->id) }}">#{{ $sportReg->registration->id }}</a>
		</td>
		<td>{{ $sportReg->registration->state }}</td>
		<td>{{ $sportReg->registration->user->name }}</td>
		<td>
			@if ($sportReg->team)
				{{ $sportReg->team->name }}
			@endif
		</td>
		<td>
			@if ($sportReg->team)
				{{ $sportReg->team->level->name }}
			@endif
		</td>
		<th>{{ str_limit($sportReg->registration->note, 50) }}</th>
	</tr>
	@endforeach
	</tbody>
</table>
