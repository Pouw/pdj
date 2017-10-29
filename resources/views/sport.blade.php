@extends('layouts.app')

@section('content')
    @include('helper.panel_top')

    <div class="panel-heading">Please fill detail about sport{{ $user->getActiveRegistration()->registrationItems->count() > 1 ? 's': ''}}</div>

    <div class="panel-body">
        @include('form.errors')
        <form class="form-horizontal" role="form" method="POST">
            {{ csrf_field() }}

            @foreach($user->getActiveRegistration()->registrationItems as $registrationItem)
                @if($registrationItem->tournamentItem->item_id === \App\Item::VOLLEYBALL)
                    <h3>{{ $registrationItem->tournamentItem->name }}</h3>
                    @include('sports/volleyball')

                @elseif($registrationItem->tournamentItem->item_id === \App\Item::BEACH_VOLLEYBALL)
                    <h3>{{ $registrationItem->tournamentItem->item->name }}</h3>
                    @include('sports/beach_volleyball')

                @elseif($registrationItem->tournamentItem->item_id === \App\Item::SOCCER)
                    <h3>{{ $registrationItem->tournamentItem->item->name }}</h3>
                    @include('sports/soccer')

                @elseif($registrationItem->tournamentItem->item_id === \App\Item::RUNNING)
                    <h3>{{ $registrationItem->tournamentItem->item->name }}</h3>
                    @include('sports/running')

                @elseif($registrationItem->tournamentItem->item_id === \App\Item::SWIMMING)
                    <h3>{{ $registrationItem->tournamentItem->item->name }}</h3>
                    @include('sports/swimming')

                @elseif($registrationItem->tournamentItem->item_id === \App\Item::BADMINTON)
                    <h3>{{ $registrationItem->tournamentItem->item->name }}</h3>
                    @include('sports/badminton')

                @endif
            @endforeach

            @include('form/footer', ['back' => '/registration'])
        </form>
    </div>

    @include('helper.panel_bottom')
@endsection
