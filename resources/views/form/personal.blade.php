
@include('form.yes_no', [
	'name' => 'member',
	'title' => 'Are you member of Alcedo Prague?',
	'default' => $user->member
])
@include('form.currency', [
	'name' => 'currency_id',
	'title' => 'Currency',
	'default' => $user->currency_id
])