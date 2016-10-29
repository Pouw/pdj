

<div class="form-group">
	<label for="badminton_singles" class="col-md-4 control-label">Singles</label>
	<div class="col-md-4 ">
		<div class="input-group">
			<span class="input-group-addon">
				<input id="badminton_singles" type="checkbox" {{ old('badminton_level', $regSport->level_id) ? 'checked' : ''}}>
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
				<input id="badminton_doubles" type="checkbox" {{ old('badminton_alt_level', $regSport->alt_level_id) ? 'checked' : ''}}>
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



