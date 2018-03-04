@extends('layouts.app')

@section('content')
	<div class="container">

		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<table class="table table-hover">
					<thead>
					<tr>
						<th class="text-center">Name</th>
						<th class="text-center">Quantity</th>
						<th class="text-center">CZK</th>
						<th class="text-center">Sale</th>
						<th class="text-center">Summary</th>
						<th class="text-center">Outreach</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($incomes as $key => $income)
						@if ($key === 'sum')
							<tr class="text-danger">
						@else
							<tr>
						@endif

							<td>{{ $income['name'] }}</td>
							<td class="text-right">{{ $income['quantity'] }}</td>
							<td class="text-right">{{ $income['czk'] ?? '' }}</td>
							<td class="text-right">{{ $income['sale_czk']  ?? '' }}</td>
							<td class="text-right">{{ $income['sum']  ?? '' }}</td>
							<td class="text-right">{{ $income['outreach_czk']  ?? '' }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			<div class="col-sm-2"></div>
		</div>

	</div>
@endsection
