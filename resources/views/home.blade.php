@extends('layouts.app')

@section('content')
	@include('helper.panel_top')

	<div class="panel-heading">Welcome</div>

	<div class="panel-body">
		@if ($user)
			 @if ($user->hasFinishedRegistration())
				<div class="row space">
					<div class="col-md-10 col-md-offset-2">
						<a class="btn btn-primary" href="{{ url('/personal/single') }}">
							<i class="fa fa-btn fa-user"></i> Edit Your Personal Info
						</a>
					</div>
				</div>
				<div class="row space">
					<div class="col-md-10 col-md-offset-2">
						<a class="btn btn-primary" href="{{ url('/summary/single') }}">
							<i class="fa fa-btn fa-eye"></i> View Summary Registration
						</a>
					</div>
				</div>
				<div class="row space">
					<div class="col-md-10 col-md-offset-2">
						<a class="btn btn-primary" href="{{ url('/registration') }}">
							<i class="fa fa-btn fa-pencil"></i> Edit Your Registration
						</a>
					</div>
				</div>
				<div class="row space">
					<div class="col-md-10 col-md-offset-2">
						<a class="btn btn-primary" href="{{ url('/payment/single') }}">
							<i class="fa fa-btn fa-credit-card"></i> Payment
						</a>
					</div>
				</div>
			@else
				<div class="col-xs-6 col-md-4 col-md-offset-2">
					<a class="btn btn-primary" href="{{ url('/personal') }}">
						<i class="fa fa-btn fa-arrow-circle-right"></i> Continue in Registration
					</a>
				</div>
			@endif
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
