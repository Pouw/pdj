@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row" >
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					Registration ID #{{ $registration->id }}
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							@include('summary.table', ['isMail' => false])
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
