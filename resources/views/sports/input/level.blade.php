
<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-4">
		<select id="{{ $name }}" class="form-control selectpicker" name="{{ $name }}">
			@if (isset($enableEmpty) && $enableEmpty)
				<option></option>
			@endif
			@foreach ($levels as $level)
				<option value="{{ $level->id }}" {{ old($name, $default) == $level->id ? ' selected' : ''}}>
					{{ $level->name }}
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
