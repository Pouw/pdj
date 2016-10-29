@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Personal information</div>

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
						@include('form.personal')
						@include('form.footer')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
