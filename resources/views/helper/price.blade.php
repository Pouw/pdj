

@isset($prices['czk'])
	{{ round($prices['czk']) }} CZK

	@isset($prices['eur'])
		/
	@endisset
@endisset

@isset($prices['eur'])
	~ {{ round($prices['eur']) }} EUR
@endisset
