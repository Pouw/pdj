
<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<div class="col-md-4 control-label">{{ $title }}</div>

	<div class="col-md-4">
		@foreach ($disciplines as $discipline)
			<label>
				<input type="checkbox" name="{{ $name }}[]" value="{{ $discipline->id }}" {{ old($name) != null && in_array($discipline->id, old($name)) ? ' checked' : '' }}>
				{{ $discipline->name }}
			</label>
		@endforeach

		@if ($errors->has($name))
			<span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
		@endif
	</div>
</div>
