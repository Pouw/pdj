

@isset($prices['czk'])
	{{ round($prices['czk']) }} CZK

	@isset($prices['eur'])
		/
	@endisset
@endisset

@isset($prices['eur'])
	@if (isset($prices['approx']) && $prices['approx'])
		~
	@endif
	{{ round($prices['eur']) }} EUR
@endisset
