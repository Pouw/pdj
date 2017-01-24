@extends('layouts.mail')

@section('content')
	<p>Hi {{ $registration->user->name }},</p>
	<p><b>thanks for your payment for Prague Rainbow Spring</b></p>
	<hr>
	<h3>Total amount : {{ $amount }} {{ \App\Currency::whereId($currencyId)->first()->iso }}</h3>
	<hr>
@endsection
