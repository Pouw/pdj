@extends('layouts.app')

@section('content')
@include('helper.panel_top')

<div class="panel-heading">Personal information</div>

<div class="panel-body">
	@include('form.errors')
	<form class="form-horizontal" role="form" method="POST">
		{{ csrf_field() }}
		@include('form.personal')
		@include('form.footer', ['showSave' => true])
	</form>
</div>

@include('helper.panel_bottom')
@endsection
