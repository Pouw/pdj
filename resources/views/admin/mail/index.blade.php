@extends('layouts.app')

@section('content')
	<div class="container">
		@include('helper.flash')
		@include('form.errors')
		<div class="row">
			<div id="admin-content" class="panel panel-default">
				<div class="panel-body">
					<table class="table">
						<thead>
						<tr>
							<td title="STOP"><i class="fa fa-remove"></i></td>
							<td>ID</td>
							<td>Title</td>
							<td>Content</td>
							<td style="display: none;">Test Sent</td>
							<td>State</td>
							<td>Sender</td>
							<td>Created at</td>
						</tr>
						</thead>
						<tbody>
						@foreach(App\Mail::orderByDesc('id')->get() as $mail)
							<tr>
								<td title="STOP"><a href="{{ url('/admin/mail/stop/' . $mail->id) }}"><i class="fa fa-remove"></i></a></td>
								<td>{{ $mail->id }}</td>
								<td>{{ $mail->title }}</td>
								<td>{{ str_limit($mail->content, 60) }}</td>
								<td style="display: none;">{{ $mail->sent_author }}</td>
								<td>
									@if($mail->status_id == 1)
										@if ($mail->done)
											<i class="fa fa-check"></i>
										@else
											<i class="fa fa-spin fa-circle-o-notch"></i>
											{{ $mail->queue()->whereSent(1)->count() }} /
											{{ $mail->queue()->count() }}
										@endif
									@else
										<i class="fa fa-stop"></i>
									@endif
								</td>
								<td>{{ $mail->user->name }}</td>
								<td>{{ $mail->created_at }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
