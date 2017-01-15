@extends('layouts.app')

@section('content')

	@if ($newRegistration)
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-md-offset-3">
				<div class="alert alert-success" role="alert">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
					Your registration has been successfully created.
				</div>
			</div>
		</div>
	</div>
	@endif

	@include('helper.panel_top')
	<div class="panel-heading">Registration summary</div>

	<div class="panel-body">
		<div class="row">
			<div class="table-responsive">
				<div class="col-md-10 col-md-offset-1">
					@include('summary.table', ['isMail' => false])
				</div>
			</div>
		</div>
		<form role="form" method="POST">
			{{ csrf_field() }}
			@include('form.footer', ['back' => '/service'])
		</form>
	</div>

	@include('helper.panel_bottom')
@endsection
