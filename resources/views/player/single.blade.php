@extends('layouts.master')

@section('content')

    <div id="playerDetail">

        <div class="social"><div class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.usopen.com%2Fen_US%2Fplayers%2Fbios%2F24461.html" data-track="Player Bio||Thomas Aiken||Share||Facebook"><img src="/images/misc/share_fb.png" alt="Share on Facebook"></a></div><div class="twitter"><a href="https://twitter.com/share?url=http%3A%2F%2Fwww.usopen.com%2Fen_US%2Fplayers%2Fbios%2F24461.html&amp;via=usopengolf&amp;text=Thomas%20Aiken" data-track="Player Bio||Thomas Aiken||Share||Twitter"><img src="/images/misc/share_twitter.png" alt="Tweet"></a></div></div>

<div class="fav"><a href="#"><span><img src="/images/misc/transparent.gif" width="16" height="10" alt="Favorite"></span><span class="label">Add to Favorites</span></a></div>

        <h1 class="header-name">{{$player->name}} {{$player->handicap()}}</h1>

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
