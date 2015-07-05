@extends('layouts.master')

@section('content')

    <style>
        .schedule {font-size: 18px; margin:0 padding:0;}
        .schedule thead tr td { background: #F0F0F0; color: #000000; font-size: 15px; padding: 10px 0px; text-transform: uppercase; font-weight: 700; text-align: center;}
        .schedule tbody tr td { text-align: center; height: 30px; vertical-align: middle; border-bottom: 1px solid #e9e9e9; border-left: 1px solid #e9e9e9; }

        .schedule .name, .schedule .champion { text-align:left; }

        .schedule tr:nth-child(even) {background: #f2f2f2}
        .schedule tr:nth-child(odd) {background: #f7f7f7}

        .schedule .course { display:block;font-size: 13px;}

        .tournament-type {
            padding: 0;
            margin: 0;
            background-color: #E3E3E3;
        }

        .tournament-type li {
            padding: 0;
            margin: 0;
        }

        .tournament-type li a {
            padding: 10px 10px;
            text-decoration: none;
            color: #353a40;
            text-transform: uppercase;
            font-weight: 700;
        }

        .tournament-type li.uk-active a,.tournament-type li:hover a {
            color: #ffffff;
            background-color: #353a40;
        }

    </style>

    <div class="main-content">
        <ul class="uk-subnav tournament-type">
            <li><a data-type="tour" href="javascript:;">Tour</a></li>
            <li><a data-type="exhibition" href="javascript:;">Exhibition</a></li>
            <li><a data-type="practice" href="javascript:;">Practice</a></li>
            <li><a data-type="cup" href="javascript:;">Cup</a></li>
        </ul>
    </div>

    <script type="text/javascript">
        $(function(){
            Dashboard.init();
        });

        var Dashboard = {
            el: {
            },
            init: function(){
                $('.tournament').addClass('uk-hidden');
                $('.tour').removeClass('uk-hidden');
                $('.tournament-type li a[data-type=tour]').parent().addClass('uk-active');

                $('.tournament-type li a').click(function(){
                    Dashboard.showType($(this).data('type'));
                });
            },

            showType: function(type) {
                $('.tournament-type li').removeClass('uk-active');
                $('.tournament-type li a[data-type='+type+']').parent().addClass('uk-active');

                $('.tournament').addClass('uk-hidden');
                $('.'+type).fadeIn(500).removeClass('uk-hidden');
            }
        }
    </script>

    <table class="uk-table schedule">
        <thead>
            <tr>
                <td>Date</td>
                <td class="name">Tournament</td>
                <td class="champion">Defending Champion</td>
                <td>Points</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($season->tournaments as $tournament)
                <tr class="tournament {{$tournament->type}}">
                    <td>{{ $tournament->short_date }}</td>
                    <td class="name"><a href="{{route('tournament', $tournament->slug)}}">{{ $tournament->name }}</a><span class="course">{{ $tournament->course->name }}</span></td>
                    <td class="champion">{{ $tournament->defending_champion() }}</td>
                    <td>{{ (($tournament->points) ? $tournament->points : '-') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
