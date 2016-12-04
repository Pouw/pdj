<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	@foreach($disciplines as $discipline)
		<div class="col-md-4 col-lg-offset-4">
			<div class="radio">
				<label>
					<input type="radio" name="{{ $name }}" value="{{ $discipline->id }}" {{ in_array($discipline->id, old($name, $default)) ? ' checked' : '' }}>
					{{ $discipline->name }}
				</label>
			</div>
		</div>
	@endforeach
</div>
