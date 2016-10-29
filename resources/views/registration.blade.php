@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Select event(s) you want to participate</div>

                <div class="panel-body">
					@include('form.errors')

                    <form class="form-horizontal" role="form" method="POST">
						{{ csrf_field() }}
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								@foreach ($sports as $sport)
									<div class="checkbox">
										<label @if($sport->title) data-toggle="tooltip" title="{{ $sport->title }}" @endif>
											<input name="sports[]" type="checkbox" value="{{ $sport->id }}" {{ in_array($sport->id, old('sports', $defaultSports)) ? ' checked' : '' }}>
											{{ $sport->name }}
										</label>
									</div>
								@endforeach
							</div>
						</div>

						@include('form.footer', ['back' => '/personal'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
