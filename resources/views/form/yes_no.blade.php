<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<div class="col-md-4 control-label">{{ $title }}</div>

	<div class="col-md-4">
		<label><input type="radio" name="{{$name}}" value="1"> Yes</label> /
		<label><input type="radio" name="{{$name}}" value="0"> No</label>


		@if ($errors->has($name))
			<span class="help-block">
               	<strong>{{ $errors->first($name) }}</strong>
			</span>
		@endif
	</div>
</div>
