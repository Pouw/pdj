<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-4">
		<input id="{{ $name }}" type="text" class="form-control" name="{{ $name }}" value="{{ old($name, $default) }}">

		@if ($errors->has($name))
			<span class="help-block">
				<strong>{{ $errors->first($name) }}</strong>
			</span>
		@endif
	</div>
</div>
