@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					{{--<form action="">--}}
						{{--<select class="selectpicker" name="sport_id" title="Sport" _onchange="this.form.submit();">--}}
							{{--<option></option>--}}
							{{--@foreach (App\Sport::all() as $sport)--}}
								{{--<option value="{{ $sport->id }}" {{ $sportId == $sport->id ? ' selected' : ''}}>--}}
									{{--{{ $sport->name }}--}}
								{{--</option>--}}
							{{--@endforeach--}}
						{{--</select>--}}
						{{--<select class="selectpicker" name="service" title="Service" _onchange="this.form.submit();">--}}
							{{--<option></option>--}}
							{{--<option value="concert" {{ $service == 'concert' ? ' selected' : ''}}>Concert Ticket</option>--}}
							{{--<option value="brunch" {{ $service == 'brunch' ? ' selected' : ''}}>Brunch</option>--}}
							{{--<option value="hosted_housing" {{ $service == 'hosted_housing' ? ' selected' : ''}}>Hosted Housing</option>--}}
							{{--<option value="outreach_support" {{ $service == 'outreach_support' ? ' selected' : ''}}>Outreach Support</option>--}}
							{{--<option value="outreach_request" {{ $service == 'outreach_request' ? ' selected' : ''}}>Outreach Request</option>--}}
						{{--</select>--}}
						{{--<select class="selectpicker" name="states[]" title="State" _onchange="this.form.submit();" multiple>--}}
							{{--@foreach(\App\Registration::$states as $state)--}}
								{{--<option {{ in_array($state, $states) ? ' selected' : ''}}>{{ $state }}</option>--}}
							{{--@endforeach--}}
						{{--</select>--}}
						{{--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>--}}
					{{--</form>--}}
				</div>
			</div>
		</div>
		<div class="row">
			@include('admin.payments_table')
		</div>
	</div>
@endsection
