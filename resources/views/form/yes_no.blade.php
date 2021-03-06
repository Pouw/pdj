<div class="form-group {{ $errors->has($name) ? ' has-error' : '' }}">
	<label for="{{ $name }}" class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-2" {!! isset($disabled) ? 'data-toggle="tooltip" data-original-title="closed / sold out"' : '' !!}>
		<label class="radio-inline {{ $disabled or '' }}">
			<input type="radio" name="{{$name}}" value="1" {{ intval(old($name, $default)) === 1 ? ' checked' : '' }} {{ $disabled or '' }}>
			Yes
		</label>
		<label class="radio-inline {{ $disabled or '' }}">
			<input type="radio" name="{{$name}}" value="0" {{ intval(old($name, $default)) === 0 ? ' checked' : '' }} {{ $disabled or '' }}>
			No
		</label>

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
					   value="{{ old('hosted_housing_date_range', ($registration->hh_from ?? '2019-05-03') . ' - ' . ($registration->hh_to ?? '2019-05-05')) }}"
						{{ $disabled or '' }}
				>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	@endif

	@if ($name === 'outreach_request')
		<div>
			<div>
				<div class="col-md-8 col-md-offset-4 from-note">
					Please read this info <a href="http://www.praguerainbow.eu/outreach.html" target="_blank">http://www.praguerainbow.eu/outreach.html</a>
				</div>
			</div>
		</div>
	@endif

	<div class="clearfix"></div>
</div>
