@extends('layouts.app')

@section('content')

	@include('helper.panel_top')
	<div class="panel-heading">Registration summary</div>

	<div class="panel-body">
		<div class="row">
			<div class="table-responsive">
				<div class="col-md-10 col-md-offset-1">
					@include('summary.table', ['isMail' => false])
				</div>
			</div>
		</div>
		<form role="form" method="POST">
			{{ csrf_field() }}
			@include('form.footer', ['back' => '/service', 'next' => !$isSinglePage, 'nextText' => 'Finish'])
		</form>
	</div>

	@include('helper.panel_bottom')
@endsection
