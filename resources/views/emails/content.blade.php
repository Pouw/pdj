@extends('layouts.mail')

@section('content')
	<p>Hi {{ $registration->user->name }},</p>

	{!! nl2br($content) !!}

@endsection
