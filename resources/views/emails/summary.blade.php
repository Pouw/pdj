@extends('layouts.mail')

@section('content')
	<p>Hi {{ Auth::user()->name }},</p>
	<p>Your registration was successful.</p>
	<p>The summary of your registration is as follows:</p>

	@include('summary.table', ['isMail' => true])

@endsection
