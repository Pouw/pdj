@extends('layouts.app')

@section('content')
	<div class="container">
		@include('helper.flash')
		@include('form.errors')
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					<table class="table">
						<thead>
						<tr>
							<th>ID</th>
							<th>Total</th>
							<th>Paid</th>
							{{--<th></th>--}}
							<th>Amounts For Pay</th>
							<th>Currency Error</th>
							<th>Notes</th>
						</tr>
						</thead>
						@foreach($data as $item)
							<tr>
								<td>
									<a href="{{ url('/admin/registration/id/' . $item['reg']->id) }}">{{ $item['reg']->id }}</a>
								</td>
								<td>{{ $item['amount'] }}</td>
								<td>{{ $item['paid'] }}</td>
								{{--<td>{{ $item['paid'] - $item['amount'] }}</td>--}}
								<td>{{ $item['amountsForPay'] }}</td>
								<td class="text-danger">
									@if($item['currencyError'])
										!!!!!!!!!!!!!!
									@endif
								</td>
								<td>
									@foreach($item['reg']->notes as $note)
										{{ $note->content }}<br>
									@endforeach
								</td>
							</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
