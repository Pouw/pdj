@if ($user->is_member && $price->czk_member)
	{{ $price->czk_member * 1 }} Kč
@elseif (intval($user->currency_id) == \App\Currency::CZK)
	{{ $price->czk * 1 }} Kč
@else
	{{ $price->eur * 1 }} €
@endif
