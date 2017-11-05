
<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-4">

		<select id="{{ $name }}" class="form-control selectpicker" name="{{ $name }}">
			@for ($i = isset($start) ? $start : 1; $i <= 20; $i = $i + 2)
				<option value="{{ $i }}" {{ old($name, $default) == $i ? ' selected' : '' }}>
					@include('helper.price', ['prices' => $registration->getPriceHelper()->getFinalPrices(\App\Price::OUTREACH_SUPPORT, $i)])
				</option>
			@endfor
		</select>

		@if ($errors->has($name))
			<span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
		@endif
	</div>
	<div>
		<div class="col-md-8 col-md-offset-4 from-note">
			Voluntary contribution towards our outreach programme. The programme facilitates students' participation.
		</div>
	</div>
</div>
