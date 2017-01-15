@extends('layouts.mail')

@section('content')
	<p>Hi {{$user->name}},</p>

	<p>thank you for registration</p>

	@include('summary.table', ['isMail' => true])

@endsection
