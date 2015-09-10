@extends('layouts.master')

@section('content')

    <h5>{{ $post->title }}</h5>
    {!! $post->content !!}
@stop
