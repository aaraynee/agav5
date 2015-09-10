@extends('layouts.master')

@section('content')

    <style>
        .courses {font-size: 18px; margin:0 padding:0;}
        .courses thead tr th { background: #F0F0F0; color: #000000; font-size: 15px; padding: 10px 0px; text-transform: uppercase; font-weight: 700; text-align: center;}
        .courses tbody tr td { text-align: center; height: 30px; vertical-align: middle; border-bottom: 1px solid #e9e9e9; border-left: 1px solid #e9e9e9; }

        .courses .name { text-align:left; }
    </style>

    <table class="uk-table courses">
        <thead>
            <tr>
                <th></th>
                <th class="name"></th>
                <th>Par</th>
                <th>Distance</th>
                <th>Scratch</th>
                <th>Slope</th>
                <th>AGA Rating</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td>
                        @if($course->course_rating > 85)
                            <i class="uk-icon-star"></i>
                        @elseif($course->course_rating < 25)
                            <i class="uk-icon-thumbs-down"></i>
                        @endif
                    </td>
                    <td class="name"><a href="{{route('course', $course->slug)}}">{{ $course->name }}</a></td>
                    <td>{{ array_sum($course->scorecard_array['par']) }}</td>
                    <td>{{ array_sum($course->scorecard_array['distance']) }}</td>
                    <td>{{ $course->scratch_rating }}</td>
                    <td>{{ $course->slope_rating }}</td>
                    <td>{{ $course->course_rating }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop