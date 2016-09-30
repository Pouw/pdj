
<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $discipline->name }}</label>

	<div class="col-md-4 form-inline">
		<div class="col-xs-1">
			<div class="control-label">
				<input id="{{ $name }}" type="checkbox" name="{{ $name }}" value="1" {{ old($name) == 1 ? ' checked' : '' }}>
			</div>
		</div>

		<div class="col-xs-6">
			<input type="text" class="form-control" name="{{ $name }}_time" value="{{ old($name . "_time") }}" title="Time" placeholder="mm:ss:hh (time)">
		</div>


		@if ($errors->has($name))
			<span class="help-block">
               	<strong>{{ $errors->first($name) }}</strong>
			</span>
		@endif
	</div>
</div>
