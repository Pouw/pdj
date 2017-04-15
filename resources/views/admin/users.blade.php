@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					<form action="" class="form-inline">
						<div class="form-group">
							<label class="sr-only" for="exampleInputName">Name</label>
							<input type="text" name="name" class="form-control" id="exampleInputName" placeholder="Name" value="{{ $name }}">
						</div>
						<select class="selectpicker" name="country_id" title="Country" data-live-search="true">
							<option></option>
							@foreach (App\Country::all() as $country)
								<option value="{{ $country->id }}" {{ $countryId == $country->id ? ' selected' : ''}}>
									{{ $country->name }}
								</option>
							@endforeach
						</select>
						<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
					</form>
				</div>

			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<table class="table">
				<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Birthdate</th>
					<th>Admin</th>
					<th>Member</th>
					<th>Currency</th>
					<th>Country</th>
					<th>City</th>
					<th>Registration</th>
				</tr>
				</thead>
				<tbody>
				@foreach($users as $user)
					<tr>
						<td>{{ $user->id }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->birthdate }}</td>
						<td>{{ $user->is_admin }}</td>
						<td>{{ $user->is_member }}</td>
						<td>{{ $user->currency ? $user->currency->iso : '' }}</td>
						<td>{{ $user->country ? $user->country->name : '' }}</td>
						<td>{{ $user->city }}</td>
						<td>
							@if($user->registration)
								<a href="{{ url('/admin/registration?id=' . $user->registration->id) }}">#{{ $user->registration->id }}</a>
							@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection
