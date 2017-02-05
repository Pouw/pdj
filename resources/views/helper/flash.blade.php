<div class="flash-message">
	@foreach (['danger', 'warning', 'success', 'info'] as $msg)
		@if(Session::has('alert-' . $msg))
			<p class="alert alert-{{ $msg }}">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{!! nl2br(e(Session::get('alert-' . $msg))) !!}
			</p>
		@endif
	@endforeach
</div>
