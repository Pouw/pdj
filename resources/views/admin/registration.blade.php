@extends('layouts.app')

@section('content')
	<div class="container">
		@include('helper.flash')
		<h1>Registration ID #{{ $registration->id }}</h1>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>State</h3>
						<strong>{{ $registration->state }}</strong>
						<h4>Change State</h4>
						<form class="form-inline" action="" method="post">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="state">State:</label>
								<select id="state" name="state" class="form-control">
									@foreach(\App\Registration::$states as $state)
										<option {{ $registration->state === $state ? 'selected' : '' }}>{{ $state }}</option>
									@endforeach
								</select>
							</div>
							<button type="submit" class="btn btn-default">Change</button>
						</form>
						<h4>Changes</h4>
						@if($registration->changes->count())
							<table class="table">
								<thead>
								<tr>
									<th>User</th>
									<th>From</th>
									<th>To</th>
									<th>At</th>
								</tr>
								</thead>
								<tbody>
								@foreach($registration->changes as $change)
									<tr>
										<td>{{ $change->user->name }}</td>
										<td>{{ $change->from }}</td>
										<td>{{ $change->to }}</td>
										<td>{{ $change->created_at }}</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Payments</h3>
						@if ($registration->payments->count())
							@include('admin.payments_table', ['payments' => $registration->payments])
						@else
							<strong>No payments found</strong>
						@endif
						<h4>Add new payment:</h4>
						<form class="form-horizontal" action="{{ url('/admin/payment/add') }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="id" value="{{ $registration->id }}">
							<div class="form-group">
								<label for="amount" class="control-label col-sm-6">Amount:</label>
								<div class="col-sm-6">
									<input type="text" id="amount" name="amount" class="form-control" value="{{ $registration->getPriceSummarize()->getTotalPrice()['price'] }}">
								</div>
							</div>
							<div class="form-group">
								<label for="currency" class="control-label col-sm-6">Currency:</label>
								<div class="col-sm-6">
									<select name="currency_id" id="currency" class="form-control">
										@foreach(\App\Currency::get() as $currency)
											<option value="{{ $currency->id }}" {{ $registration->user->currency_id === $currency->id ? 'selected' : '' }}>{{ $currency->iso }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-6 col-sm-6">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="set_paid" value="1" checked> Set as paid
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-6 col-sm-6">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="send_mail" value="1" checked> Send mail
										</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-6 col-sm-6">
									<button type="submit" class="btn btn-default">Add</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h3>Registration Information</h3>
				@include('summary.table', ['isMail' => false])
			</div>
			<div class="col-md-6">
				<h3>User Information</h3>
				@include('summary.user', ['user' => $registration->user])
			</div>
		</div>
		<div class="row">

		</div>
	</div>
@endsection
