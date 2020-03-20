<table class="table table-hover">
	<thead>
	<tr>
		<th>#</th>
		<th>State</th>
		<th>Amount</th>
		<th>Currency</th>
		<th>€</th>
		<th>Text</th>
		<th title="Bank Status">BS</th>
		<th>By</th>
		<th>At</th>
		<th>PayId</th>
		<th>Reg</th>
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
			<td>{{ $payment->bank_status }}</td>
			<td>{{ $payment->user->name }}</td>
			<td>{{ $payment->created_at }}</td>
			<td>{{ $payment->pay_id }}</td>
			<td><a href="{{ url('/admin/registration/id/' . $payment->registration_id) }}">{{ $payment->registration_id }}</a></td>
		</tr>
	@endforeach
	</tbody>
</table>
