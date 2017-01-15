
<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<div class="col-md-4 control-label">{{ $title }}</div>

	<div class="col-md-2">
		<div class="radio">
			@foreach($disciplines as $discipline)
			<label>
				<input type="radio" name="{{ $name }}" value="{{ $discipline->id }}" {{ $discipline->id == old($name, $default) ? ' checked' : '' }}>
				{{ $discipline->name }}
			</label>
			@endforeach
		</div>
	</div>
</div>
