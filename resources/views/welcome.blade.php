@extends('layouts.app')

@section('content')
@include('helper.panel_top')

<div class="panel-heading">Welcome</div>

<div class="panel-body">
	@if(Auth::user())
		<div class="col-xs-6 col-md-4 col-md-offset-2">
			<a class="btn btn-primary" href="{{ url('/personal') }}">
				<i class="fa fa-btn fa-arrow-circle-right"></i> Continue in Registration
			</a>
		</div>
	@else
		<div class="row">
			<div class="col-md-12 text-center">
			<a class="btn btn-primary" href="{{ url('/register') }}">
				<i class="fa fa-btn fa-user-plus"></i> Create New Registration
			</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center"><p>&nbsp;</p></div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
			<a class="btn btn-primary" href="{{ url('/login') }}">
				<i class="fa fa-btn fa-sign-in"></i> Login
			</a>
			</div>
		</div>
	@endif
</div>

@include('helper.panel_bottom')
@endsection
