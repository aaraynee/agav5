@extends('layouts.master')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Tournament</th>
                <th>Defending Champion</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($season->tournaments as $tournament)
                <tr>
                    <td></td>
                    <td><a href="{{route('tournament', $tournament->slug)}}">{{ $tournament->name }}</a></td>
                    <td></td>
                    <td>{{ $tournament->points }}</td>
                </tr>        
            @endforeach
        </tbody>
    </table>
@stop