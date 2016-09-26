<div class="form-group{{ $errors->has('volleyball_level') ? ' has-error' : '' }}">
    <label for="volleyball_level" class="col-md-4 control-label">Level</label>

    <div class="col-md-6">
        <select id="volleyball_level" class="form-control" name="volleyball_level">
            @foreach ($levels as $level)
                <option value="{{ $level->id }}">{{ $level->name }}</option>
            @endforeach
        </select>

        @if ($errors->has('volleyball_level'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

</div>

<div class="form-group{{ $errors->has('volleyball_team') ? ' has-error' : '' }}">
	<label for="volleyball_team" class="col-md-4 control-label">Name of your team</label>

	<div class="col-md-6">
		<input id="volleyball_team" type="text" class="form-control" name="volleyball_team" value="{{ old('volleyball_team') }}">

		@if ($errors->has('volleyball_team'))
			<span class="help-block">
                	<strong>{{ $errors->first('volleyball_team') }}</strong>
				</span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('volleyball_club') ? ' has-error' : '' }}">
	<label for="volleyball_team" class="col-md-4 control-label">Name of your club</label>

	<div class="col-md-6">
		<input id="volleyball_club" type="text" class="form-control" name="volleyball_club" value="{{ old('volleyball_club') }}">

		@if ($errors->has('volleyball_club'))
			<span class="help-block">
                	<strong>{{ $errors->first('volleyball_club') }}</strong>
				</span>
		@endif
	</div>
</div>
