@extends('layouts.app')

@section('content')
@include('helper.panel_top')

<div class="panel-heading">Select event(s) you want to participate</div>

<div class="panel-body">
    @include('form.errors')

    <form class="form-horizontal" role="form" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                @foreach ($sports as $sport)
                    <div class="checkbox">
                        <label @if($sport->title) data-toggle="tooltip" title="{{ $sport->title }}" @endif>
                            <input name="sports[]" type="checkbox" value="{{ $sport->id }}" {{ in_array($sport->id, old('sports', $defaultSports)) ? ' checked' : '' }}>
                            {{ $sport->name }}
							@if (!empty($sport->day))
								<small style="color: #979797">({{ $sport->day }})</small>
							@endif
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        @include('form.footer', ['back' => '/personal'])
    </form>
</div>

@include('helper.panel_bottom')
@endsection
