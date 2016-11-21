<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<label class="col-md-4 control-label">{{ $title }}</label>

	<div class="col-md-8 btn-group team-switcher" data-toggle="buttons">
		<label class="btn btn-default active">
			<input name="{{ $name }}" type="radio" value="find" checked="checked">
			<i class="fa fa-btn fa-search"></i> Select team
		</label>
		<label class="btn btn-default">
			<input name="{{ $name }}" type="radio" value="create">
			<i class="fa fa-btn fa-plus"></i> Create new team
		</label>
	</div>


</div>

<div id="{{ $name }}_find" class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
	<div class="col-md-4 col-md-offset-4">
		<select class="form-control selectpicker" name="{{ $name }}_id" data-live-search="true" title="Teams">
			@foreach ($teams->sortBy('name') as $team)
				<option value="{{ $team->id }}" data-subtext="level {{ $team->level->name }}" {{ old($name . '_id', $default) == $team->id ? ' selected' : ''}}>
					{{ $team->name }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div id="{{ $name }}_create" class="form-group{{ $errors->has($name) ? ' has-error' : '' }}" style="display: none">
	<div class="col-md-4 col-md-offset-4">
		<input name="{{ $name }}_name" type="text" class="form-control" placeholder="Team name">
	</div>
	<div class="col-md-4">
		<select name="{{ $name }}_level_id" class="form-control selectpicker" title="Level">
			@foreach ($levels as $level)
				<option value="{{ $level->id }}">
					Level {{ $level->name }}
				</option>
			@endforeach
		</select>
	</div>
</div>
