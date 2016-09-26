@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Select sport(s) you want to participate</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST">
						{{ csrf_field() }}
						<div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								@foreach ($sports as $sport)
									<div class="checkbox">
										<label>
											<input name="sports[]" type="checkbox" value="{{ $sport->id }}" {{ in_array($sport->id, $selectedSportIds) ? ' checked' : '' }}>
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

						<div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								<button type="submit" class="btn btn-primary">
									<i class="fa fa-btn fa-chevron-circle-right"></i> Next
								</button>
							</div>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
