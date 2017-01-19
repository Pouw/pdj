
@include('sports/input/discipline_badminton', [
	'title' => 'Category',
	'name' => 'badminton_discipline',
	'disciplines' => $regSport->sport->disciplines,
    'default' => $regSport->disciplines->count() > 0 ? $regSport->disciplines->first()->discipline_id : null,
])

<div class="form-group{{ $errors->has('badminton_level') ? ' has-error' : '' }}">
	<label for="badminton_singles" class="col-md-4 control-label">Singles</label>
	<div class="col-md-4">
		<select id="badminton_singles" class="form-control selectpicker" name="badminton_level" title="Level for singles">
			<option value="{{ \App\Level::NO_PLAY }}" {{ intval(old('badminton_level', $regSport->level_id)) === \App\Level::NO_PLAY ? ' selected' : ''}}>Don't want play to singles</option>
			<option></option>
			@foreach ($regSport->sport->levels as $level)
				<option value="{{ $level->id }}" {{ old('badminton_level', $regSport->level_id) == $level->id ? ' selected' : ''}}>
					Level {{ $level->name }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group{{ $errors->has('badminton_alt_level') ? ' has-error' : '' }}">
	<label for="badminton_doubles" class="col-md-4 control-label">Doubles</label>
	<div class="col-md-4">
		<select id="badminton_doubles" class="form-control selectpicker" name="badminton_alt_level" title="Level for doubles">
			<option value="{{ \App\Level::NO_PLAY }}" {{ intval(old('badminton_alt_level', $regSport->alt_level_id)) === \App\Level::NO_PLAY ? ' selected' : ''}}>Don't want play to doubles</option>
			<option></option>
			@foreach ($regSport->sport->levels as $level)
				<option value="{{ $level->id }}" {{ old('badminton_alt_level', $regSport->alt_level_id) == $level->id ? ' selected' : ''}}>
					Level {{ $level->name }}
				</option>
			@endforeach
		</select>
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

<div id="badminton_team_name" style="{{ old('badminton_find_partner', $regSport->find_partner) ? 'display: none' : ''}}">
@include('form.text', ['name' => 'badminton_team_name', 'title' => 'Name of your partner for doubles', 'default' => $regSport->team_name])
</div>



