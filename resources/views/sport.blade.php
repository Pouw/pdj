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
							@elseif($regSport->sport->id === 2)
								@include('sports/beach_volleyball')
							@elseif($regSport->sport->id === 3)
								@include('sports/soccer')
							@elseif($regSport->sport->id === 4)
								@include('sports/swimming')
							@elseif($regSport->sport->id === 6)
								@include('sports/badminton')
							@endif
						@endforeach

						@include('form/footer', ['back' => '/registration'])
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
