@extends('layouts.master')

@section('content')

    <style>

        .heading { width: 100%; background: #003865; }
        .heading h3 { padding: 10px 0 10px 10px;color: #ffffff; font-weight: 400; text-transform: uppercase;}

        .latest { border-collapse: collapse; }
        .latest thead { background: #003865; color: #ffffff; text-transform: uppercase;  }
        .latest thead tr.tournament { background: #d8d8d8; color: #000000; }
        .latest thead tr th { text-align: center; font-weight: 400; }
        .latest tbody tr td { border: 1px solid #d8d8d8; text-align: center; }

        .rankings { border-collapse: collapse; border: 1px solid #d8d8d8; }

        .rankings:hover { background: #d8d8d8; }


        .rankings tr td { color: #000000; font-weight: 300; font-size: 15px; vertical-align: middle; border: none; }
        .rankings tr td.position { font-size: 25px; }
        .rankings tr td.name { font-size: 18px; }
        .rankings tr td.points { text-align: center; font-size: 35px; font-weight: 500; }
        .rankings img {
            width: 80px;
            height: 80px;
            border-radius: 40px;
            -webkit-border-radius: 40px;
            -moz-border-radius: 40px;
        }

        ul.news { list-style: none; }
        ul.news li { border-bottom: 1px solid #888888; }
        ul.news li a { text-transform: uppercase; color: #000000; background: #d8d8d8; padding: 10px 5px; display: block; text-decoration: none; font-weight: 300; font-size: 12px; }
        ul.news li:hover a { font-weight: 300; background: #003865; color: #ffffff; }

        ul.news li span.date { float:right }

    </style>

    <div class="uk-grid">
        <div class="uk-width-2-3">
            <ul class="news">
                <li>
                    <div class="heading">
                        <h3>Latest News</h3>
                    </div>
                </li>
                @foreach($latest_news as $news)
                    <li><a href="{{ $news->link }}">{{ $news->title }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="uk-width-1-3">
            <table class="uk-table latest">
                <thead>
                <tr>
                    <th colspan="4">Upcoming Tournament</th>
                </tr>
                <tr class="tournament">
                    <th colspan="4">{{ $upcoming->name }}</th>
                </tr>
                </thead>
            </table>
            <table class="uk-table latest">
                <thead>
                    <tr>
                        <th colspan="4">Latest Scores</th>
                    </tr>
                    <tr class="tournament">
                        <th colspan="4">{{ $tournament->name }}</th>
                    </tr>
                    <tr>
                        <th>Pos</th>
                        <th></th>
                        <th>Score</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tournament->rounds as $round)
                        <tr>
                            <td>{{ $round->position }}</td>
                            <td>{{ $round->player->name }}</td>
                            <td>{{ $round->adjusted }}</td>
                            <td>{{ $round->points }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="uk-grid">
        <div class="uk-width-1-1">
            <div class="heading">
                <h3>World Rankings</h3>
            </div>
        </div>

        @foreach($rankings as $player)

            <div class="uk-width-1-3">
                <a href="/player/{{$player['details']->slug}}">
                    <table class="uk-table rankings">
                        <tr>
                            <td class="position" rowspan="2">{{$player['stats']['rankings_position']}}</td>
                            <td rowspan="2"><img src="img/players/{{ strtolower($player['details']->lastname) }}.png"></td>
                            <td><span class="flag-icon flag-icon-{{$player['details']->country_code}}"></span></td>
                            <td class="name">{{$player['details']->firstname}} {{$player['details']->lastname}}</td>
                        </tr>
                        <tr>
                            <td class="points" colspan="2">{{$player['stats']['rankings_points']}}</td>
                        </tr>
                    </table>
                </a>
            </div>

        @endforeach
    </div>

@stop