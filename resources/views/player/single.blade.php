@extends('layouts.master')

@section('content')

    <div id="playerDetail">


        <h1 class="header-name">{{$player->name}} {{$player->handicap}}</h1>

        <div class="player">
            {!!$player->flag!!}

            <div class="country">
                {{$player->country}}
            </div>
        </div>

        <div class="playerInfo">
            {!!$player->photo!!}

            <div class="bio-wrapper">
                <div>
                    AGA Tour Profile
                </div>

                <div class="history">
                    <dl class="col_1">
                        <dt>Age:</dt>

                        <dd>{{$player->age}}</dd>
                    </dl>

                    <dl class="col_1">
                        <dt>AGA Debut:</dt>

                        <dd>{{$player->debut}}</dd>
                    </dl>

                    <dl class="col_1">
                        <dt>Height:</dt>

                        <dd>{{$player->height}} cms</dd>
                    </dl>

                    <dl class="col_1">
                        <dt>Weight:</dt>

                        <dd>{{$player->weight}} kgs</dd>
                    </dl>

                    <dl class="col_1">
                        <dt>College:</dt>

                        <dd>{{$player->college}}</dd>
                    </dl>

                    <dl class="col_1">
                        <dt>Clubs:</dt>

                        <dd>{{$player->clubs}}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bio-text">
            {!!$player->bio!!}
        </div>
    </div>

    <style>
        table.stats tr th { text-align: center; border: 1px #d8d8d8 solid; }
        table.stats tr td { text-align: center; border: 1px #d8d8d8 solid; }
    </style>

    <ul class="uk-tab" data-uk-tab="{connect:'#player_tabs'}">
        <li class="uk-active"><a href="">Profile</a></li>
        <li><a href="">Stats</a></li>
        <li><a href="">Handicap Tracker</a></li>
    </ul>

    <ul id="player_tabs" class="uk-switcher uk-margin">
        <li>@include('player.stats.season')</li>
        <li>@include('player.stats.history')</li>
        <li></li>
    </ul>

@stop
