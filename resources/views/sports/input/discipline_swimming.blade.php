
<div class="form-group{{ $errors->has($name) || $errors->has($timeName) ? ' has-error' : '' }}">
	<label for="{{ $id }}" class="col-md-4 control-label">{{ $discipline->name }}</label>

	<div class="col-md-4 form-inline">

		<div class="input-group">
			<span class="input-group-addon">
				<input id="{{ $id }}" type="checkbox" name="{{ $name }}[]" value="{{ $discipline->id }}" {{ in_array($discipline->id, old($name, $default)) ? ' checked' : '' }}>
			</span>
			<input type="text" class="form-control swimming_discipline_time" disciplineid="{{ $discipline->id }}" name="{{ $timeName }}" value="{{ old($timeName, $defaultTime) }}" title="Time" placeholder="mm:ss.hh (time)">
		</div>

		@if ($errors->has($name))
			<span class="help-block">
               	<strong>{{ $errors->first($name) }}</strong>
			</span>
		@endif

		@if ($errors->has($timeName))
			<span class="help-block">
               	<strong>{{ $errors->first($timeName) }}</strong>
			</span>
		@endif
	</div>
</div>
