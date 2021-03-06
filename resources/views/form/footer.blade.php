<div class="form-group">
	<div class="col-xs-6 col-md-4 col-md-offset-2">
		@if (isset($isSinglePage) && $isSinglePage)
			<a class="btn btn-default" href="{{ url('/') }}">
				<i class="fa fa-btn fa-home"></i> Home
			</a>
		@elseif (isset($back))
			<a class="btn btn-primary" href="{{ url($back) }}">
				<i class="fa fa-btn fa-chevron-circle-left"></i> Previous
			</a>
		@endif
	</div>

	<div class="col-xs-6 col-xs-offset-0 col-md-4 col-md-offset-0 text-right">
		@if (!isset($next) || $next !== false)
			<button type="submit" class="btn btn-primary">
				@if (isset($isSinglePage) && $isSinglePage && isset($showSave))
					<i class="fa fa-btn fa-save"></i> Save
				@else
					<i class="fa fa-btn fa-chevron-circle-right"></i> {{ $nextText ?? 'Next' }}
				@endif
			</button>
		@endif

		@if (isset($paymentRedirect) && $paymentRedirect)
			<a href="{{ url('/payment/redirect') }}" class="btn btn-success btn-lg">
				<i class="fa fa-lg fa-credit-card"></i>
				Pay online
			</a>
		@endif

	</div>
</div>
