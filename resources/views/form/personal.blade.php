
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
@include('form.country', [
	'name' => 'country_id',
	'title' => 'Country',
	'default' => (!empty($user->country_id) ? $user->country_id : \App\Country::CZECHIA)
])
@include('form.text', [
	'name' => 'city',
	'title' => 'City',
	'default' => $user->city,
])
