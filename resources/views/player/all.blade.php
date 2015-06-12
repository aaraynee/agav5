@extends('layouts.master')

@section('content')
    <h2>Players</h2>
    <ul class="uk-grid" data-uk-grid-margin>
        @foreach ($players as $player)
            <li class="player uk-width-medium-1-5">{!!$player->flag!!}<a href="{{route('player', $player->slug)}}">{{ $player->fullname }}</a></li>
        @endforeach
    </ul>
@stop