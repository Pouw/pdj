@extends('layouts.app')

@section('content')
    @include('helper.panel_top')

    <div class="panel-heading">Please fill detail about sport{{ $user->registration->sports->count() > 1 ? 's': ''}}</div>

    <div class="panel-body">
        @include('form.errors')
        <form class="form-horizontal" role="form" method="POST">
            {{ csrf_field() }}

            @foreach($user->registration->sports as $regSport)
                @if($regSport->sport->id === \App\Sport::VOLLEYBALL)
                    <h3>{{ $regSport->sport->name }}</h3>
                    @include('sports/volleyball')

                @elseif($regSport->sport->id === \App\Sport::BEACH_VOLLEYBALL)
                    <h3>{{ $regSport->sport->name }}</h3>
                    @include('sports/beach_volleyball')

                @elseif($regSport->sport->id === \App\Sport::SOCCER)
                    <h3>{{ $regSport->sport->name }}</h3>
                    @include('sports/soccer')

                @elseif($regSport->sport->id === \App\Sport::RUNNING)
                    <h3>{{ $regSport->sport->name }}</h3>
                    @include('sports/running')

                @elseif($regSport->sport->id === \App\Sport::SWIMMING)
                    <h3>{{ $regSport->sport->name }}</h3>
                    @include('sports/swimming')

                @elseif($regSport->sport->id === \App\Sport::BADMINTON)
                    <h3>{{ $regSport->sport->name }}</h3>
                    @include('sports/badminton')

                @endif
            @endforeach

            @include('form/footer', ['back' => '/registration'])
        </form>
    </div>

    @include('helper.panel_bottom')
@endsection
