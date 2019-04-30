@extends('layouts.mail')

@section('content')
	@if ($isDefaultHeaderFooter)
		<p>Hi {{ $user->name }},</p>
	@endif

	{!! nl2br($mail->content) !!}

@endsection
