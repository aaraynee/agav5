@extends('layouts.master')

@section('content')
    @foreach ($courses as $course)
        <a href="{{route('course', $course->slug)}}">{{ $course->name }}</a><br>
    @endforeach
@stop