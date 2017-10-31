@extends('layouts.app')

@section('content')
	<div class="{{ $itemId == App\Item::SWIMMING ? 'container-fluid' : 'container'}} ">
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					<form action="">
						<select class="selectpicker" name="tournament_id" title="Tournament">
							@foreach (App\Tournament::all() as $tournament)
								<option value="{{ $tournament->id }}" {{ $tournamentId == $tournament->id ? ' selected' : ''}}>
									{{ $tournament->name }}
								</option>
							@endforeach
						</select>
						<select class="selectpicker" name="item_id" title="Sport">
							<option value="">&nbsp;</option>
							@foreach (App\Item::all() as $item)
								<option value="{{ $item->id }}" {{ $itemId == $item->id ? ' selected' : ''}}>
									{{ $item->name }}
								</option>
							@endforeach
						</select>
						<select class="selectpicker" name="service" title="Service">
							<option value="">&nbsp;</option>
							<option value="concert" {{ $service == 'concert' ? ' selected' : ''}}>Concert Ticket</option>
							<option value="brunch" {{ $service == 'brunch' ? ' selected' : ''}}>Brunch</option>
							<option value="hosted_housing" {{ $service == 'hosted_housing' ? ' selected' : ''}}>Hosted Housing</option>
							<option value="outreach_support" {{ $service == 'outreach_support' ? ' selected' : ''}}>Outreach Support</option>
							<option value="outreach_request" {{ $service == 'outreach_request' ? ' selected' : ''}}>Outreach Request</option>
						</select>
						<select class="selectpicker" name="states[]" title="State" multiple>
							@foreach(\App\Registration::$states as $state)
								<option {{ in_array($state, $states) ? ' selected' : ''}}>{{ $state }}</option>
							@endforeach
						</select>
						<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
					</form>
				</div>
			</div>
		</div>

		@include('admin.registration.list_table')
	</div>
@endsection
