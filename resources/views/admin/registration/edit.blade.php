@extends('layouts.app')

@section('content')
	<div class="container admin-registration-view">
		@include('helper.flash')
		<h1>Registration ID #{{ $registration->id }}</h1>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">State</div>
					<div class="panel-body">
						<h3>State: <span class="text-primary">{{ $registration->state }}</span></h3>
						<form class="form-inline" action="" method="post">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="state">Change State to:</label>
								<select id="state" name="state" class="form-control">
									@foreach(\App\Registration::$states as $state)
										<option {{ $registration->state === $state ? 'selected' : '' }}>{{ $state }}</option>
									@endforeach
								</select>
							</div>
							<button type="submit" class="btn btn-default">Change</button>
						</form>
						<h5>Changes</h5>
						@if($registration->changes->count())
							<table class="table">
								<thead>
								<tr>
									<th>From</th>
									<th>To</th>
									<th>By</th>
									<th>At</th>
								</tr>
								</thead>
								<tbody>
								@foreach($registration->changes as $change)
									<tr>
										<td>{{ $change->from }}</td>
										<td>{{ $change->to }}</td>
										<td>{{ $change->user->name }}</td>
										<td>{{ $change->created_at }}</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						@endif
					</div>
				</div>
				<div class="panel panel-warning">
					<div class="panel-heading">Internal notes</div>
					<div class="panel-body">
						<form class="form-inline" action="{{ url('/admin/registration/add-note') }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="registration_id" value="{{ $registration->id }}">
							<textarea class="form-control" rows="1" name="content" title="Note" placeholder="New Internal Note"></textarea>
							<button type="submit" class="btn btn-default">Add</button>
						</form>
						@if($registration->notes->count())
							<table class="table">
								<thead>
								<tr>
									<th>Note</th>
									<th>By</th>
									<th>At</th>
								</tr>
								</thead>
								<tbody>
								@foreach($registration->notes as $note)
									<tr>
										<td>{!! nl2br(e($note->content)) !!}</td>
										<td>{{ $note->user->name }}</td>
										<td>{{ $note->created_at }}</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						@endif
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">Payments</div>
					<div class="panel-body">
						@if ($registration->payments->count())
							@include('admin.payment.table', ['payments' => $registration->payments])
						@else
							<strong>No payments found yet</strong>
						@endif
						<h4>Add new payment:</h4>
						<form class="form-horizontal" action="{{ url('/admin/payment/add') }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="id" value="{{ $registration->id }}">
							<div class="form-group">
								<label for="amount" class="control-label col-sm-6">Amount:</label>
								<div class="col-sm-6">
									<input type="text" id="amount" name="amount" class="form-control"
										   value="{{$registration->getPriceSummarize()->getTotalPrice()[$registration->user->currency->code] }}"
									>
								</div>
							</div>
							<div class="form-group">
								<label for="currency" class="control-label col-sm-6">Currency:</label>
								<div class="col-sm-6">
									<select name="currency_id" id="currency" class="form-control">
										@foreach(\App\Currency::get() as $currency)
											<option value="{{ $currency->id }}" {{ $registration->user->currency_id == $currency->id ? 'selected' : '' }}>{{ $currency->iso }}</option>
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

			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Registration Information</div>
					<div class="panel-body">
						@include('summary.table', ['isMail' => false])
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">User Information</div>
					<div class="panel-body">
						@include('summary.user', ['user' => $registration->user])
					</div>
				</div>

			</div>
		</div>

	</div>
@endsection
