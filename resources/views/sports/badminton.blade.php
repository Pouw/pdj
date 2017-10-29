
@include('sports/input/discipline_badminton', [
	'title' => 'Category',
	'name' => 'badminton_discipline',
	'disciplines' => $registrationItem->tournamentItem->item->disciplines,
    'default' => $registrationItem->disciplines->count() > 0 ? $registrationItem->disciplines->first()->discipline_id : null,
])

<div class="form-group{{ $errors->has('badminton_level') ? ' has-error' : '' }}">
	<label for="badminton_singles" class="col-md-4 control-label">Singles</label>
	<div class="col-md-4">
		<select id="badminton_singles" class="form-control selectpicker" name="badminton_level" title="Level for singles">
			<option value="{{ \App\Level::NO_PLAY }}" {{ intval(old('badminton_level', $registrationItem->level_id)) === \App\Level::NO_PLAY ? ' selected' : ''}}>Don't want to play singles</option>
			<option></option>
			@foreach ($registrationItem->tournamentItem->item->levels as $level)
				<option value="{{ $level->id }}" {{ old('badminton_level', $registrationItem->level_id) == $level->id ? ' selected' : ''}}>
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
			<option value="{{ \App\Level::NO_PLAY }}" {{ intval(old('badminton_alt_level', $registrationItem->alt_level_id)) === \App\Level::NO_PLAY ? ' selected' : ''}}>Don't want to play doubles</option>
			<option></option>
			@foreach ($registrationItem->tournamentItem->item->levels as $level)
				<option value="{{ $level->id }}" {{ old('badminton_alt_level', $registrationItem->alt_level_id) == $level->id ? ' selected' : ''}}>
					Level {{ $level->name }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<div class="col-md-4 col-md-offset-4">
		<label class="control-label">
			<input type="checkbox" name="badminton_find_partner" value="1" {{ old('badminton_find_partner', $registrationItem->find_partner) ? 'checked' : '' }}>
			Help me find a partner for doubles
		</label>
	</div>
</div>

<div id="badminton_team_name" style="{{ old('badminton_find_partner', $registrationItem->find_partner) ? 'display: none' : ''}}">
@include('form.text', ['name' => 'badminton_team_name', 'title' => 'Name of your partner for doubles', 'default' => $registrationItem->team_name])
</div>



