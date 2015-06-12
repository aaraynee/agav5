@extends('layouts.master')

@section('content')

    <style>
        table.stats tr th { text-align: center; border: 1px #d8d8d8 solid; } 
        table.stats tr td { text-align: center; border: 1px #d8d8d8 solid; } 
    </style>

    <table>
        <thead>
            <tr>
                <th><h2>{{$player->name}}</h2></th>
                <th><h1>{{$player->handicap()}}</h1></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>


    <ul class="uk-tab" data-uk-tab="{connect:'#player_tabs'}">
        <li class="uk-active"><a href="">Profile</a></li>
        <li><a href="">Stats</a></li>
        <li><a href="">Handicap Tracker</a></li>
    </ul>

    <ul id="player_tabs" class="uk-switcher uk-margin">
        <li>@include('player.stats.season')</li>
        <li>@include('player.stats.history')</li>
        <li></li>
    </ul>

@stop