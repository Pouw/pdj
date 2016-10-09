@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Registration Summary</div>

                <div class="panel-body">

					<div class="row">
						<div class="table-responsive">
							<div class="col-md-10 col-md-offset-1">
							<table class="table">
								<thead>
								<tr>
									<th></th>
									<th>Price</th>
								</tr>
								</thead>
								<tbody>
								@foreach($user->registration->sports as $regSport)
								<tr>
									<td>{{ $regSport->sport->name }}</td>
									<td>@include('helper.price', ['price' => $regSport->sport->price])</td>
								</tr>
								@endforeach
								<tr>
									<td>Brunch</td>
									{{--<th>{{ $price->where('id', $price::BRUNCH)->first() }}</th>--}}
									{{--<th>{{ $priceBrunch }}</th>--}}
									<td>@include('helper.price', ['price' => $price->where('id', $price::BRUNCH)->first()])</td>
								</tr>
								<tr>
									<td>Hosted Housing</td>
									<td>@include('helper.price', ['price' => $price->where('id', $price::HOSTED_HOUSING)->first()])</td>
								</tr>
								</tbody>
								<tfoot>
									<th>Total Price</th>
									<th>{{ $priceSummarize->getTotalPrice()['price'] }} € / Kč</th>
								</tfoot>
							</table>
							</div>
						</div>
					</div>

					@include('form.footer', ['back' => '/service'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
