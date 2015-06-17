@extends('layouts.master')

@section('content')
    {{$season->name}}
    <table class="uk-table">
        <thead>
            <tr>
                <th>Ranking</th>
                <th></th>
                <th>Played</th>
                <th>Wins</th>
                <th>Top 2</th>
                <th>Points</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($players as $player)
<?php print_r($player); ?>
            @endforeach
        </tbody>
    </table>
@stop