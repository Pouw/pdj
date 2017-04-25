@extends('layouts.app')

@section('content')
	<div class="container">
		@include('helper.flash')
		@include('form.errors')
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					<table class="table">
						@foreach($data as $item)
							<tr>
								<td><a href="{{ url('/admin/registration?id=' . $item['reg']->id) }}">{{ $item['reg']->id }}</a></td>
								<td>{{ $item['amount'] }}</td>
								<td>{{ $item['paid'] }}</td>
								<td>{{ $item['paid'] - $item['amount'] }}</td>
							</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
