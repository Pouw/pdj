<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-4">
		<label class="radio-inline"><input type="radio" name="{{$name}}" value="1" {{ intval(old($name, $default)) === 1 ? ' checked' : '' }}> Yes</label>
		<label class="radio-inline"><input type="radio" name="{{$name}}" value="0" {{ intval(old($name, $default)) === 0 ? ' checked' : '' }}> No</label>


		@if ($errors->has($name))
			<span class="help-block">
               	<strong>{{ $errors->first($name) }}</strong>
			</span>
		@endif
	</div>

	@if ($name === 'hosted_housing')
	<div id="hosted_housing_date_range" style="{{ intval(old($name, $default)) === 0 ? 'display: none;' : '' }}">
		<div>
			<div class="col-md-8 col-md-offset-4 from-note">
				Check your arrival / departure date for Hosted Housing:
			</div>
		</div>
		<div>
			<div class="col-md-4 col-md-offset-4">
				<input type="text" name="hosted_housing_date_range" class="form-control" title="Arrival - Departure Range"
					   value="{{ old('hosted_housing_date_range', ($user->registration->hh_from ?? '2017-04-28') . ' - ' . ($user->registration->hh_to ?? '2017-05-01')) }}">
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	@endif

	@if ($name === 'outreach_request')
		<div>
			<div>
				<div class="col-md-8 col-md-offset-4 from-note">
					Please, read this info <a href="http://www.praguerainbow.eu/outreach-program.html" target="_blank">http://www.praguerainbow.eu/outreach-program.html</a>
				</div>
			</div>
		</div>
	@endif

	<div class="clearfix"></div>
</div>
