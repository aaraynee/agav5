@extends('layouts.master')

@section('content')
    @foreach ($seasons as $season)
        <a href="{{route('season', $season->slug)}}">{{ $season->name }}</a><br>
    @endforeach
@stop