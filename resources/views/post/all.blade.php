@extends('layouts.master')

@section('content')

    <style>
        .pagination {
            height: 50px;
            margin: 10px auto;
            list-style: none;
        }

        .pagination li {
            padding: 5px;
            margin: 0 5px;
            float:left;
            border: 1px solid #003865;
            background: #ffffff;
        }

        .pagination li.active {
            color: #ffffff;
            background: #003865;
        }

    </style>

    @foreach($posts as $post)
        <div class="uk-grid">
            <div class="uk-width-1-4"></div>
            <div class="uk-width-3-4">
                <h5><a href="{{ $post->link }}">{{ $post->title }}</a></h5>
                {{ $post->excerpt }}
                <a href="{{ $post->link }}">Read More</a>
            </div>
        </div>
    @endforeach

    {!! $posts->render() !!}

@stop
