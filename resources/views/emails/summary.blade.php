@extends('layouts.mail')

@section('content')
	<p>Hi {{$user->name}},</p>
	<p>Your registration was successful.</p>
	<p>You have made registration for:</p>

	@include('summary.table', ['isMail' => true])

@endsection
