@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">

					@if(Auth::user())
						<div class="col-xs-6 col-md-4 col-md-offset-2">
							<a class="btn btn-primary" href="{{ url('/registration') }}">
								<i class="fa fa-btn fa-arrow-circle-right"></i> Continue Registration
							</a>
						</div>
					@else
						<div class="col-xs-6 col-md-4 col-md-offset-2">
							<a class="btn btn-primary" href="{{ url('/register') }}">
								<i class="fa fa-btn fa-user-plus"></i> Create New Registration
							</a>
						</div>
						<div class="col-xs-6 col-xs-offset-0 col-md-4 col-md-offset-0 text-right">
							<a class="btn btn-primary" href="{{ url('/login') }}">
								<i class="fa fa-btn fa-sign-in"></i> Login
							</a>
						</div>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
