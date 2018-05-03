@extends('layouts.app')

@section('content')
	<div class="container">
		@include('helper.flash')
		@include('form.errors')
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					<form action="{{ url('/admin/mail/add') }}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<label>Recipients filter</label>
							<select class="selectpicker" name="tournament_id" title="Tournament">
								<option></option>
								@foreach (App\Tournament::all() as $tournament)
									<option value="{{ $tournament->id }}" {{ old('tournament_id') == $tournament->id ? ' selected' : ''}}>
										{{ $tournament->name }}
									</option>
								@endforeach
							</select>
							<select class="selectpicker" name="sport_id" title="Sport">
								<option></option>
								@foreach (App\Item::all() as $sport)
									<option value="{{ $sport->id }}" {{ old('sport_id') == $sport->id ? ' selected' : ''}}>
										{{ $sport->name }}
									</option>
								@endforeach
							</select>
							<select class="selectpicker" name="states[]" title="State" multiple>
								@foreach(\App\Registration::$states as $state)
									<option {{ in_array($state, (array) old('states')) ? ' selected' : ''}}>{{ $state }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="title">Title</label>
							<input id="title" type="text" class="form-control" name="title" value="{{ old('title', 'Prague Rainbow Spring') }}">
						</div>
						<div class="form-group">
    						<label for="content">Content</label>
							<textarea id="content" class="form-control" name="content" >{{ old('content') }}</textarea>
						</div>
						<div class="form-group">
							Attachment:
							@foreach(File::allFiles(storage_path('app/public/mail')) as $file)
								<div class="form-check">
									<label>
										<input type="checkbox" name="attachments[]" value="{{ $file }}">
										{{ basename($file) }}
									</label>
								</div>
							@endforeach
						</div>
						<button type="submit" class="btn btn-primary" onclick="confirm('Are you sure?')"><i class="fa fa-mail"></i> Send mail</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">

		</div>
	</div>
@endsection
