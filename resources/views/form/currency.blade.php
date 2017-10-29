<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-4">
		<select id="{{ $name }}" class="form-control selectpicker" name="{{ $name }}">
			@foreach ($currencies as $currency)
				<option value="{{ $currency->id }}" {{ old($name, $default) == $currency->id ? ' selected' : ''}}>
					{{ $currency->iso }} ({{ $currency->short }})
				</option>
			@endforeach
		</select>

		@if ($errors->has($name))
			<span class="help-block">
				<strong>{{ $errors->first($name) }}</strong>
			</span>
		@endif
	</div>
</div>
