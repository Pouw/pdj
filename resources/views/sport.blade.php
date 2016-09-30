@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Please fill detail about sport{{ $user->registration->sports->count() > 1 ? 's': ''}}</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST">
						{{ csrf_field() }}

						@foreach($user->registration->sports as $regSport)
							<h3>{{ $regSport->sport->name }}</h3>
							@if($regSport->sport->id === 1)
								@include('sports/volleyball')
							@elseif($regSport->sport->id === 3)
								@include('sports/soccer')
							@elseif($regSport->sport->id === 4)
								@include('sports/swimming')
							@elseif($regSport->sport->id === 6)
								@include('sports/badminton')
							@endif
						@endforeach

						<div class="form-group">
							<div class="col-md-6 col-md-offset-2">
								<a class="btn btn-primary" href="{{ url('/registration') }}">
									<i class="fa fa-btn fa-chevron-circle-left"></i> Previous
								</a>
							</div>

							<div class="col-md-2">
								<button type="submit" class="btn btn-primary">
									<i class="fa fa-btn fa-chevron-circle-right"></i> Next
								</button>
							</div>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
