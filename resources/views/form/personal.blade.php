
@include('form.text', [
	'name' => 'name',
	'title' => 'Full Name',
	'default' => $user->name,
])
@include('form.date', [
	'name' => 'birthdate',
	'title' => 'Birthdate',
	'default' => $user->birthdate,
])
@include('form.yes_no', [
	'name' => 'is_member',
	'title' => 'Are you a member of Alcedo Prague or Aquamen?',
	'default' => $user->is_member
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
