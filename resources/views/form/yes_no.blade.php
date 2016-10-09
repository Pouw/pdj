<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<div class="col-md-4 control-label">{{ $title }}</div>

	<div class="col-md-4">
		<label class="radio-inline"><input type="radio" name="{{$name}}" value="1" {{ intval(old($name, $default)) === 1 ? ' checked' : '' }}> Yes</label>
		<label class="radio-inline"><input type="radio" name="{{$name}}" value="0" {{ intval(old($name, $default)) === 0 ? ' checked' : '' }}> No</label>


		@if ($errors->has($name))
			<span class="help-block">
               	<strong>{{ $errors->first($name) }}</strong>
			</span>
		@endif
	</div>
</div>
