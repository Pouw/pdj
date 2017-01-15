@if ($user->is_member && $price->czk_member)
	{{ $price->czk_member * 1 }}&nbsp;Kč
@elseif (intval($user->currency_id) == \App\Currency::CZK)
	{{ $price->czk * 1 }}&nbsp;Kč
@else
	{{ $price->eur * 1 }}&nbsp;€
@endif
