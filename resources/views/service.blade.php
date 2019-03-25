@extends('layouts.app')

@section('content')
@include('helper.panel_top')

<div class="panel-heading">Select service</div>

<div class="panel-body">
	<form class="form-horizontal" role="form" method="POST">
		{{ csrf_field() }}

		@if ($registration->isOnlySinger())
			{{--@include('form.yes_no', ['name' => 'brunch', 'title' => 'Brunch', 'start' => 0, 'default' => $registration->brunch])--}}
			@include('form.outreach', ['name' => 'outreach_support', 'title' => 'Outreach Support', 'start' => 0, 'default' => $registration->outreach_support])
		@else
			{{--@include('form.yes_no', ['name' => 'brunch', 'title' => 'Brunch', 'start' => 0, 'default' => $registration->brunch])--}}
{{--			@include('form.yes_no', ['name' => 'concert', 'title' => 'Concert Doodles and Podium Paris', 'start' => 0, 'default' => $registration->concert, 'disabled' => 'disabled'])--}}
			@include('form.yes_no', ['name' => 'hosted_housing', 'title' => 'Hosted Housing', 'start' => 0, 'default' => $registration->hosted_housing, 'disabled' => 'disabled'])
			@include('form.outreach', ['name' => 'outreach_support', 'title' => 'Outreach Support', 'start' => 0, 'default' => $registration->outreach_support])
			@include('form.yes_no', ['name' => 'outreach_request', 'title' => 'Outreach Request', 'start' => 0, 'default' => $registration->outreach_request])
		@endif

		<div class="form-group">
			<label for="note" class="col-md-4 control-label">Your Comments</label>
			<div class="col-md-8">
				<textarea id="note" name="note" class="form-control">{{ old('note', $registration->note) }}</textarea>
			</div>
		</div>


		@include('form.footer', ['back' => '/registration'])
	</form>
</div>

@include('helper.panel_bottom')
@endsection
