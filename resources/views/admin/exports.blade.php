@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					<form action="{{ url('/admin/export') }}" method="get">
						<select class="selectpicker" name="ext" title="extension">
							<option selected>xls</option>
							<option>xlsx</option>
						</select>
						<button type="submit" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Export</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
