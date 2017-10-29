@extends('layouts.app')

@section('content')
@include('helper.panel_top')

<div class="panel-heading">Select events you want to participate in</div>

<div class="panel-body">
    @include('form.errors')

    <form class="form-horizontal" role="form" method="POST">
        {{ csrf_field() }}
        <div class="form-group days">
			@foreach(['saturday' => 'Saturday', 'sunday' => 'Sunday', 'monday' => 'Monday', 'all' => ''] as $day => $dayTitle)
				<div class="col-md-10 col-xs-10 col-md-offset-1 col-xs-offset-1 {{ $day }}">
					<div class="col-md-4">{{ $dayTitle }}</div>
					<div class="col-md-8">
						@foreach ($items->where('day', $day) as $item)
							<div class="checkbox {{ $item->pivot->status_id == \App\Status::DISABLED ? 'disabled' : '' }}">
								@if ($item->pivot->status_id == \App\Status::DISABLED && in_array($item->pivot->id, old('tournament_item_ids', $defaultSports)))
									<input type="hidden" name="tournament_item_ids[]" value="{{ $item->id }}">
								@endif
								<label
									@if ($item->title)
										data-toggle="tooltip" title="{{ $item->title }}"
									@elseif ($item->pivot->status_id == \App\Status::DISABLED)
										data-toggle="tooltip" title="locked / closed"
									@endif
								>
									<input
											name="tournament_item_ids[]"
											type="checkbox"
											value="{{ $item->pivot->id }}"
											{{ in_array($item->pivot->id, old('tournament_item_ids', $defaultSports)) ? ' checked' : '' }}
											{{ $item->pivot->status_id == \App\Status::DISABLED ? 'disabled' : '' }}
									>
									{{ $item->id == \App\Item::VISITOR ? "I'm a visitor only" : $item->name }}
								</label>
							</div>
						@endforeach
					</div>
				</div>
			@endforeach
		</div>

        @include('form.footer', ['back' => '/personal'])
    </form>
</div>

@include('helper.panel_bottom')
@endsection
