@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					{{--Registrations ---}}
					<form action="">
						<select class="form-control" name="sport_id" title="Sport" onchange="this.form.submit();">
							<option></option>
							@foreach (App\Sport::all() as $sport)
								<option value="{{ $sport->id }}" {{ $sportId == $sport->id ? ' selected' : ''}}>
									{{ $sport->name }}
								</option>
							@endforeach
						</select>
					</form>
				</div>

				@if ($sportId)
					<table class="table">
						<thead>
						<tr>
							<th>ID</th>
							<th>State</th>
							<th>User</th>
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
						@foreach (App\RegistrationSport::whereSportId($sportId)->get() as $sportReg)
							<tr>
								<td>
									<a href="{{ url('/admin/registration?id=' . $sportReg->registration->id) }}">#{{ $sportReg->registration->id }}</a>
								</td>
								<td>{{ $sportReg->registration->state }}</td>
								<td>{{ $sportReg->registration->user->name }}</td>
								<td>{{ $sportReg->registration->user->is_member ? 'Yes' : 'No' }}</td>
								<td>{{ $sportReg->registration->user->currency ? $sportReg->registration->user->currency->iso  : '' }}</td>
								<td>{{ $sportReg->registration->user->country ? $sportReg->registration->user->country->name : '' }}</td>

								<td>{{ $sportReg->registration->brunch ? 'Yes' : 'No' }}</td>
								<td>{{ $sportReg->registration->hosted_housing ? 'Yes' : 'No' }}</td>
								<td>{{ $sportReg->registration->outreach_support }}</td>
								<td>{{ $sportReg->registration->outreach_request ? 'Yes' : 'No' }}</td>
								<td>
									@if (!empty($sportReg->registration->note))
										<span data-toggle="popover" data-trigger="hover" data-placement="bottom"
											  data-content="{{$sportReg->registration->note}}">
								note
							</span>
									@endif
								</td>
								<td>{{ $sportReg->registration->created_at }}</td>
								<td>{{ $sportReg->registration->updated_at }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@else
					<table class="table">
						<thead>
						<tr>
							<th></th>
							@foreach(\App\Registration::$states as $state)
								<th>{{ $state }}</th>
							@endforeach
						</tr>
						</thead>
						<tbody>
						@foreach (\App\Sport::all() as $sport)
							<tr>
								<td>{{ $sport->name }}</td>
								@foreach(\App\Registration::$states as $state)
									<td>{{ \App\RegistrationSport::join('registrations', 'registrations.id', '=', 'registration_sports.registration_id')
									->where('registrations.state', $state)
									->where('sport_id', $sport->id)
									->count() }}</td>
								@endforeach

							</tr>
						@endforeach
						<tr>
							<td>Concert ticket</td>
							@foreach(\App\Registration::$states as $state)
								<td>{{ \App\Registration::whereConcert(1)->whereState($state)->count() }}</td>
							@endforeach
						</tr>
						<tr>
							<td>Brunch</td>
							@foreach(\App\Registration::$states as $state)
								<td>{{ \App\Registration::whereBrunch(1)->whereState($state)->count() }}</td>
							@endforeach
						</tr>
						<tr>
							<td>Hosted Housing</td>
							@foreach(\App\Registration::$states as $state)
								<td>{{ \App\Registration::whereHostedHousing(1)->whereState($state)->count() }}</td>
							@endforeach
						</tr>
						<tr>
							<td>Outreach Support</td>
							@foreach(\App\Registration::$states as $state)
								<td>{{ \App\Registration::where('outreach_support', '>', 0)->whereState($state)->count() }}</td>
							@endforeach
						</tr>
						<tr>
							<td>Outreach Request</td>
							@foreach(\App\Registration::$states as $state)
								<td>{{ \App\Registration::whereOutreachRequest(1)->whereState($state)->count() }}</td>
							@endforeach
						</tr>

						</tbody>
					</table>
				@endif
			</div>
		</div>
	</div>
@endsection
