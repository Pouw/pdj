@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Volleyball form</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST">
						{{ csrf_field() }}


						<div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								<button type="submit" class="btn btn-primary">
									Next <i class="fa fa-btn fa-chevron-circle-right"></i>
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
