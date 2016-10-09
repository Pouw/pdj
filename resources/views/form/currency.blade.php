<div class="form-group">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-4">
		<select id="{{ $name }}" class="form-control" name="{{ $name }}">
			@foreach ($currencies as $currency)
				<option value="{{ $currency->id }}" {{ old($name, $default) == $currency->id ? ' selected' : ''}}>
					{{ $currency->iso }} ({{ $currency->short }})
				</option>
			@endforeach
		</select>
	</div>
</div>
