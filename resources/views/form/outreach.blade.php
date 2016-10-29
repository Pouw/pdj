
<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-4">

		<select id="{{ $name }}" class="form-control selectpicker" name="{{ $name }}">
			@for ($i = isset($start) ? $start : 1; $i <= 16; $i++)
				<option value="{{ $i }}" {{ old($name, $default) == $i ? ' selected' : '' }}>
					@if ($user->currency_id === \App\Currency::CZK)
						{{ $outreachPrice->czk * $i }} Kč
					@else
						{{ $outreachPrice->eur * $i }} €
					@endif
				</option>
			@endfor
		</select>

		@if ($errors->has($name))
			<span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
		@endif
	</div>
</div>
