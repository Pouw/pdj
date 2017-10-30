@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					<form action="">
						<select class="selectpicker" name="tournament_id" title="Tournament">
							<option></option>
							@foreach (App\Tournament::all() as $tournament)
								<option value="{{ $tournament->id }}" {{ $tournamentId == $tournament->id ? ' selected' : ''}}>
									{{ $tournament->name }}
								</option>
							@endforeach
						</select>
						<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
					</form>
				</div>
			</div>
		</div>

		<table class="table table-hover">
			<thead>
			<tr>
				<th></th>
				@foreach(\App\Registration::$states as $state)
					<th>{{ $state }}</th>
				@endforeach
			</tr>
			</thead>
			<tbody>
			@foreach (\App\Item::all() as $item)
				<tr>
					<td><a href="{{ url("/admin/registration/list?tournament_id=$tournamentId&item_id=$item->id") }}">{{ $item->name }}</a></td>
					@foreach(\App\Registration::$states as $state)
						<td><a href="{{ url("/admin/registrations?tournament_id=$tournamentId&item_id=$item->id&states[]=$state") }}">
							{{ \App\RegistrationItem::join('registrations', 'registrations.id', '=', 'registration_items.registration_id')
						->join('tournament_items', 'tournament_items.id', '=', 'registration_items.tournament_item_id')
						->where('registrations.tournament_id', $tournamentId)
						->where('registrations.state', $state)
						->where('tournament_items.item_id', $item->id)
						->count() }}</a></td>
					@endforeach
				</tr>
			@endforeach
			<tr>
				<td><a href="{{ url("/admin/registrations?service=concert") }}">Concert Ticket</a></td>
				@foreach(\App\Registration::$states as $state)
					<td>
						<a href="{{ url("/admin/registrations?service=concert&states[]=$state") }}">
							{{ \App\Registration::whereConcert(1)->whereTournamentId($tournamentId)->whereState($state)->count() }}
						</a>
					</td>
				@endforeach
			</tr>
			<tr>
				<td><a href="{{ url("/admin/registrations?service=brunch") }}">Brunch</a></td>
				@foreach(\App\Registration::$states as $state)
					<td>
						<a href="{{ url("/admin/registrations?service=brunch&states[]=$state") }}">
							{{ \App\Registration::whereBrunch(1)->whereTournamentId($tournamentId)->whereState($state)->count() }}
						</a>
					</td>
				@endforeach
			</tr>
			<tr>
				<td><a href="{{ url("/admin/registrations?service=hosted_housing") }}">Hosted Housing</a></td>
				@foreach(\App\Registration::$states as $state)
					<td>
						<a href="{{ url("/admin/registrations?service=hosted_housing&states[]=$state") }}">
							{{ \App\Registration::whereHostedHousing(1)->whereTournamentId($tournamentId)->whereState($state)->count() }}
						</a>
					</td>
				@endforeach
			</tr>
			<tr>
				<td><a href="{{ url("/admin/registrations?service=outreach_support") }}">Outreach Support</a></td>
				@foreach(\App\Registration::$states as $state)
					<td>
						<a href="{{ url("/admin/registrations?service=outreach_support&states[]=$state") }}">
							{{ \App\Registration::where('outreach_support', '>', 0)->whereTournamentId($tournamentId)->whereState($state)->count() }}
						</a>
					</td>
				@endforeach
			</tr>
			<tr>
				<td><a href="{{ url("/admin/registrations?service=outreach_request") }}">Outreach Request</a></td>
				@foreach(\App\Registration::$states as $state)
					<td>
						<a href="{{ url("/admin/registrations?service=outreach_request&states[]=$state") }}">
							{{ \App\Registration::whereOutreachRequest(1)->whereTournamentId($tournamentId)->whereState($state)->count() }}
						</a>
					</td>
				@endforeach
			</tr>

			</tbody>
		</table>

	</div>
@endsection
