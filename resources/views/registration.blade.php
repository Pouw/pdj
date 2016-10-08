@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Select sport(s) you want to participate</div>

                <div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
                    <form class="form-horizontal" role="form" method="POST">
						{{ csrf_field() }}
						<div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								@foreach ($sports as $sport)
									<div class="checkbox">
										<label>
											<input name="sports[]" type="checkbox" value="{{ $sport->id }}" {{ in_array($sport->id, old('sports', $defaultSports)) ? ' checked' : '' }}>
											{{ $sport->name }}
										</label>
									</div>
								@endforeach
								<div class="checkbox">
									<label>
										<input name="visitor" type="checkbox" value="1">
										I'm only visitor
									</label>
								</div>
							</div>
						</div>


						@include('form.personal')
						@include('form.footer')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
