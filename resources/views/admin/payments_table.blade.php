<table class="table table-hover">
	<thead>
	<tr>
		<th>#</th>
		<th>State</th>
		<th>Amount</th>
		<th>Currency</th>
		<th>€</th>
		<th>Text</th>
		<th>By</th>
		<th>At</th>
	</tr>
	</thead>
	<tbody>
	@foreach($payments as $payment)
		<tr class="bg-{{ $payment->state}}">
			<td>{{ $payment->id }}</td>
			<td>{{ $payment->state }}</td>
			<td class="text-right">{{ $payment->amount }}</td>
			<td>{{ $payment->currency->iso }}</td>
			<td class="text-right">{{ $payment->amount_eur }} €</td>
			<td>{{ $payment->result_text }}</td>
			<td>{{ $payment->user->name }}</td>
			<td>{{ $payment->created_at }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
