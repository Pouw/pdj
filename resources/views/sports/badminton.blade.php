

<div class="form-group">
	<label for="badminton_singles" class="col-md-4 control-label">Singles</label>
	<div class="col-md-4 ">
		<div class="input-group">
			<span class="input-group-addon">
				<input id="badminton_singles" name="badminton_singles" type="checkbox" value="1" {{ old('badminton_singles', $regSport->level_id) ? 'checked' : ''}}>
			</span>
			<select class="form-control selectpicker" name="badminton_level" title="Level for singles">
				<option></option>
				@foreach ($regSport->sport->levels as $level)
					<option value="{{ $level->id }}" {{ old('badminton_level', $regSport->level_id) == $level->id ? ' selected' : ''}}>
						Level {{ $level->name }}
					</option>
				@endforeach
			</select>
		</div>
	</div>
</div>

<div class="form-group">
	<label for="badminton_doubles" class="col-md-4 control-label">Doubles</label>
	<div class="col-md-4 ">
		<div class="input-group">
			<span class="input-group-addon">
				<input id="badminton_doubles" name="badminton_doubles" type="checkbox" value="1" {{ old('badminton_doubles', $regSport->alt_level_id) ? 'checked' : ''}}>
			</span>
			<select class="form-control selectpicker" name="badminton_alt_level" title="Level for doubles">
				<option></option>
				@foreach ($regSport->sport->levels as $level)
					<option value="{{ $level->id }}" {{ old('badminton_alt_level', $regSport->alt_level_id) == $level->id ? ' selected' : ''}}>
						Level {{ $level->name }}
					</option>
				@endforeach
			</select>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-md-4 col-md-offset-4">
		<label class="control-label">
			<input type="checkbox" name="badminton_find_partner" value="1" {{ old('badminton_find_partner', $regSport->find_partner) ? 'checked' : '' }}>
			Help me find partner for doubles
		</label>
	</div>
</div>

@include('form.text', ['name' => 'badminton_team_name', 'title' => 'Name of your partner for doubles', 'default' => $regSport->team_name])



