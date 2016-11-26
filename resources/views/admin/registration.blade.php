@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row" >
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					Registration ID #{{ $registration->id }}
				</div>
			</div>
		</div>
	</div>
@endsection
