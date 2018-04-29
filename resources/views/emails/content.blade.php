@extends('layouts.mail')

@section('content')
	<p>Hi {{ $user->name }},</p>

	{!! nl2br($mail->content) !!}

@endsection
