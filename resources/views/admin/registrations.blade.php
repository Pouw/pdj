@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row" >
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					Registrations
				</div>
			<table class="table">
				<thead>
				<tr>
					<th>ID</th>
					<th>User</th>
					<th>Email</th>
					<th title="Alcedo Member">A. M.</th>
					<th>Currency</th>
					<th>Country</th>
					<th>Brunch</th>
					<th>Housing</th>
					<th title="Outreach Support">O. S.</th>
					<th title="Outreach Request">O. R.</th>
					<th>Note</th>
					<th>Created</th>
					<th>Updated</th>
				</tr>
				</thead>
				<tbody>
			@foreach (App\Registration::all() as $reg)
				<tr>
					<td><a href="{{ url('/admin/registration?id=' . $reg->id) }}">#{{ $reg->id }}</a></td>
					<td>{{ $reg->user->name }}</td>
					<td>{{ $reg->user->email }}</td>
					<td>{{ $reg->user->member ? 'Yes' : 'No' }}</td>
					<td>{{ $reg->user->currency->iso }}</td>
					<td>{{ $reg->user->country->name }}</td>

					<td>{{ $reg->brunch ? 'Yes' : 'No' }}</td>
					<td>{{ $reg->hosted_housing ? 'Yes' : 'No' }}</td>
					<td>{{ $reg->outreach_support }}</td>
					<td>{{ $reg->outreach_request ? 'Yes' : 'No' }}</td>
					<td>
						@if (!empty($reg->note))
							<span data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="{{$reg->note}}">
								note
							</span>
						@endif
					</td>
					<td>{{ $reg->created_at }}</td>
					<td>{{ $reg->updated_at }}</td>
				</tr>
			@endforeach
				</tbody>
			</table>
		</div>
		</div>
	</div>
@endsection
