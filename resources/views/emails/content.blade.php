@extends('layouts.mail')

@section('content')
	@if ($isDefaultHeaderFooter)
		<p>Hi {{ $user->name }},</p>
	@endif

	{!! nl2br($mail->content) !!}

	@if ($isDefaultHeaderFooter)
		<p>
			For information, news and updates follow us via
			<a href="http://www.praguerainbow.eu/" target="_blank">web</a>
			or
			<a href="https://www.facebook.com/Prague-Rainbow-Spring-404635169567940/" target="_blank">FB</a>.
		</p>
		<p>
			Prague Rainbow Spring Team
		</p>
	@endIf

@endsection
