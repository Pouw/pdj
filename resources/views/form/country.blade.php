<div class="form-group">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-4">
		<select id="{{ $name }}" class="form-control selectpicker" name="{{ $name }}" data-live-search="true">
			@foreach ($countries as $country)
				<option value="{{ $country->id }}" {{ old($name, $default) == $country->id ? ' selected' : ''}}>
					{{ $country->name }}
				</option>
			@endforeach
		</select>
	</div>
</div>
