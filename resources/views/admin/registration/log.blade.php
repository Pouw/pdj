@extends('layouts.app')

@section('content')
	<div class="container">
		@include('helper.flash')
		@include('form.errors')
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					<table class="table">
						@foreach($logs as $log)
							<tr>
								<td>{{ $log->created_at }}</td>
								<td>
									@if (isset($log->data->registration->sports))
										@foreach($log->data->registration->sports as $sport)
											{{ $sport->sport_id}},
										@endforeach
									@endif
								</td>
								{{--<td>@dump($log->data->registration)</td>--}}
							</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
