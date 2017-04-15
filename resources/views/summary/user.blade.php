<table class="table">
	<tbody>
	<tr>
		<th>ID</th>
		<td>{{ $user->id }}</td>
	</tr>
	<tr>
		<th>Name</th>
		<td>{{ $user->name }}</td>
	</tr>
	<tr>
		<th>Email</th>
		<td>{{ $user->email }}</td>
	</tr>
	<tr>
		<th>Birthdate</th>
		<td>{{ $user->birthdate }}</td>
	</tr>
	<tr>
		<th>Admin</th>
		<td>{{ $user->is_admin }}</td>
	</tr>
	<tr>
		<th>Member</th>
		<td>{{ $user->is_member }}</td>
	</tr>
	<tr>
		<th>Currency</th>
		<td>{{ $user->currency ? $user->currency->iso : '' }}</td>
	</tr>
	<tr>
		<th>Country</th>
		<td>{{ $user->country ? $user->country->name : '' }}</td>
	</tr>
	<tr>
		<th>City</th>
		<td>{{ $user->city }}</td>
	</tr>
	</tbody>
</table>
