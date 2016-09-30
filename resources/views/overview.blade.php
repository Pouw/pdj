@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Registration Overview</div>

                <div class="panel-body">

					<div class="row">
						<p>DOTO: Overview, Price, Payment link</p>
					</div>

                    <div class="form-group">
                        <div class="col-xs-6 col-md-4 col-md-offset-2">
							<a class="btn btn-primary" href="{{ url('/service') }}">
								<i class="fa fa-btn fa-chevron-circle-left"></i> Previous
							</a>
                        </div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
