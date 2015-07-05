@extends('layouts.master')

@section('content')

    <style>
        .schedule {font-size: 18px; margin:0 padding:0;}
        .schedule thead tr td { background: #F0F0F0; color: #000000; font-size: 15px; padding: 10px 0px; text-transform: uppercase; font-weight: 700; text-align: center;}
        .schedule tbody tr td { text-align: center; height: 30px; vertical-align: middle; border-bottom: 1px solid #e9e9e9; border-left: 1px solid #e9e9e9; }

        .schedule .tournament, .schedule .champion { text-align:left; }

        .schedule tr:nth-child(even) {background: #f2f2f2}
        .schedule tr:nth-child(odd) {background: #f7f7f7}
    </style>


    <table class="uk-table schedule">
        <thead>
            <tr>
                <td>Date</td>
                <td class="tournament">Tournament</td>
                <td class="champion">Defending Champion</td>
                <td>Points</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($season->tournaments as $tournament)
                <tr>
                    <td>{{ $tournament->short_date }}</td>
                    <td class="tournament"><a href="{{route('tournament', $tournament->slug)}}">{{ $tournament->name }}</a></td>
                    <td class="champion">{{ $tournament->defending_champion() }}</td>
                    <td>{{ (($tournament->points) ? $tournament->points : '-') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
