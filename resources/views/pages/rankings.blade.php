@extends('layouts.master')

@section('content')

    <style>
        .standings {font-size: 18px; margin:0 padding:0;}
        .standings thead tr td { background: #F0F0F0; color: #000000; font-size: 15px; padding: 10px 0px; text-transform: uppercase; font-weight: 700; text-align: center;}
        .standings tbody tr td { text-align: center; height: 30px; vertical-align: middle; border-bottom: 1px solid #e9e9e9; border-left: 1px solid #e9e9e9; }

        .standings .player { text-align:left; }

        .standings tr:nth-child(even) {background: #f2f2f2}
        .standings tr:nth-child(odd) {background: #f7f7f7}
    </style>

    <div class="main-content">
            <h1>World Rankings</h1>
    </div>
    <table callpadding="0" cellspacing="0" class="uk-table standings">
        <thead>
            <tr>
                <td>Pos</td>
                <td>Country</td>
                <td class="player">Player</td>
                <td>Played</td>
                <td>Wins</td>
                <td>Top 2</td>
                <td>Points</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($standings->table() as $player)
                <tr>
                    <td>{{$player['stats']['rankings_position']}}</td>
                    <td><span class="flag-icon flag-icon-{{$player['details']->country_code}}"></span></td>
                    <td class="player">{{$player['details']->firstname}} {{$player['details']->lastname}}</td>
                    <td>{{$player['stats']['rankings_played']}}</td>
                    <td>{{ ((isset($player['stats']['rankings_wins'])) ? $player['stats']['rankings_wins'] : '-' )}}</td>
                    <td>{{ ((isset($player['stats']['rankings_top2'])) ? $player['stats']['rankings_top2'] : '-' )}}</td>
                    <td>{{$player['stats']['rankings_points']}}</td>
                    <td>{!!$player['stats']['change']!!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
