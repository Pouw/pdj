<table class="table">
	<thead>
	<tr>
		<th>#</th>
		<th>Amount</th>
		<th>Currency</th>
		<th>By</th>
		<th>At</th>
	</tr>
	</thead>
	<tbody>
	@foreach($payments as $payment)
		<tr class="bg-success">
			<td>{{ $payment->id }}</td>
			<td>{{ $payment->amount }}</td>
			<td>{{ $payment->currency->iso }}</td>
			<td>{{ $payment->user->name }}</td>
			<td>{{ $payment->created_at }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
