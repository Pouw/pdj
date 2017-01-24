@extends('layouts.mail')

@section('content')
	<p>Hi {{ Auth::user()->name }},</p>
	<p>Your registration was successful.</p>
	<p>You have made registration for:</p>

	@include('summary.table', ['registration' => Auth::user()->registration, 'isMail' => true])

@endsection
