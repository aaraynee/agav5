@extends('layouts.master')

<style>
    .player-tile {
        background: #ffffff;
        height: 190px;
        width: 95%;
        margin: 0 auto;
    }

    .player-tile .title {
        color: #00365f;
        font-size: 100%;
        padding-left: 10px;
        line-height: 35px;
        height: 35px;
        display: block;
    }
    .player-tile a img {
        width: 100%;
        height: 115px;
    }

    .player-tile .country {
        color: #000000;
        padding: 15px 10px 0;
        display: block;
        line-height: 22px;
        font-size: .8em;
    }

    .player-tile .country img {
        width: 26px;
        height: 18px;
        padding: 0 5px 3px 0;
        display: inline;
        vertical-align: middle;
    }

</style>


@section('content')
    <h2>Players</h2>
    <ul class="uk-grid" data-uk-grid-margin>
        @foreach ($players as $player)
            <li class="uk-width-medium-1-4">
                <div class="player-tile">
                    <div class="title">{{ $player->name }}</div>
                    <a href="{{route('player', $player->slug)}}">
                        {!!$player->photo!!}
                    </a>
                    <div class="country">{!!$player->flag!!} {{$player->country}}</div>
                </div>
            </li>
        @endforeach
    </ul>
@stop
