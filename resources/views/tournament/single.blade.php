@extends('layouts.master')

@section('content')
    <h1>{{$tournament->name}}</h1>
    <a href="{{route('course', $tournament->course->slug)}}">{{$tournament->course->name}}</a>

    <table>
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tournament->rounds as $round)
                <tr>
                    <td>{{$round->position}}</td>
                    <td>{{$round->player->image}}</td>
                    <td>{{$round->player->name}}</td>
                    <td>{{$round->total}}</td>
                    <td>{{$round->adjusted}}</td>
                    <td>{{$round->points}}</td>
                </tr>
            @endforeach        
        </tbody>
    </table>
@stop