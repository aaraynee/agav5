@extends('layouts.master')

@section('content')

<style>
    .scoreboard {font-size: 18px; margin:0 padding:0;}
    .scoreboard thead tr td { background: #F0F0F0; color: #000000; font-size: 15px; padding: 10px 0px; text-transform: uppercase; font-weight: 700; text-align: center;}
    .scoreboard tbody tr td { text-align: center; height: 30px; vertical-align: middle; border-bottom: 1px solid #e9e9e9; border-left: 1px solid #e9e9e9; }
    .scoreboard .player { text-align:left; }
    .scoreboard tr:nth-child(even) {background: #f2f2f2}
    .scoreboard tr:nth-child(odd) {background: #f7f7f7}

    .scorecard {font-weight: normal;
  font-size: 16px;
  border-left: 1px solid #e9e9e9;
  border-right: 1px solid #e9e9e9;}
    .scorecard tr td {  height: 17px; line-height: 17px;}
    .scorecard tr.par td {border-top: 5px solid #c7c7c7;}

    .scorecard .eagle, .legend .eagle { background-color: #156399; color: #FFFFFF; }
    .scorecard .birdie, .legend .birdie { background-color: #99D7E8; }
    .scorecard .par, .legend .par { background-color: #FFFFFF; }
    .scorecard .bogey, .legend .bogey { background-color: #F7B540; }
    .scorecard .dblbogey, .legend .dblbogey { background-color: #F55D00; color: #FFFFFF; }
    .scorecard .tplbogey, .legend .tplbogey { background-color: #A50D00; color: #FFFFFF; }

</style>

    <h1>{{$tournament->name}}</h1>
    <a href="{{route('course', $tournament->course->slug)}}">{{$tournament->course->name}}</a>

    <table class="uk-table scoreboard">
        <thead>
            <tr>
                <td>Pos</td>
                <td>Country</td>
                <td class="player">Player</td>
                <td>Strokes</td>
                <td>Total</td>
                <td>Adjusted</td>
                <td>Points</td>
                <td></td>
            </tr>
        </tdead>
        <tbody>
            @foreach ($tournament->rounds as $round)
                <tr>
                    <td>{{$round->position}}</td>
                    <td>{!!$round->player->flag!!}</td>
                    <td class="player">{{$round->player->name}}</td>
                    <td>{{$round->strokes}}</td>
                    <td>{{$round->scoreboard_total}}</td>
                    <td>{{$round->scoreboard}}</td>
                    <td>{{$round->points}}</td>
                    <td><i class="uk-icon-plus-square-o uk-icon-justify" id="{{$round->id}}-plus" data-uk-toggle="{target:'#{{$round->id}}, #{{$round->id}}-plus, #{{$round->id}}-minus'}"></i>
                        <i class="uk-icon-minus-square-o uk-icon-justify uk-hidden" id="{{$round->id}}-minus" data-uk-toggle="{target:'#{{$round->id}}, #{{$round->id}}-plus, #{{$round->id}}-minus'}"></i>
                </tr>
                <tr id="{{$round->id}}" class="uk-hidden">
                    <td colspan="8">
                        <table class="uk-table scorecard">
                            <tr>
                                <td>Hole</td>
                                @for($i =1;$i<=18;$i++)
                                    <td>{{$i}}</td>
                                    @if($i == 9)
                                        <td>OUT</td>
                                    @elseif($i == 18)
                                        <td>IN</td>
                                        <td>TOTAL</td>
                                    @endif
                                @endfor
                            </tr>
                            <tr class="par">
                                <td>Par</td>
                                @for($i =1;$i<=18;$i++)
                                    <td>{{$round->tournament->course->scorecard_array['par'][$i]}}</td>
                                    @if($i == 9)
                                        <td>OUT</td>
                                    @elseif($i == 18)
                                        <td>IN</td>
                                        <td>TOTAL</td>
                                    @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Metres</td>
                                @for($i =1;$i<=18;$i++)
                                    <td>{{$round->tournament->course->scorecard_array['distance'][$i]}}</td>
                                    @if($i == 9)
                                        <td>OUT</td>
                                    @elseif($i == 18)
                                        <td>IN</td>
                                        <td>TOTAL</td>
                                    @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Score</td>
                                @for($i =1;$i<=18;$i++)
                                    <td class="{{$round->score_class()[$i]}}">{{$round->score_array[$i-1]}}</td>
                                    @if($i == 9)
                                        <td>{{$round->score('out')}}</td>
                                    @elseif($i == 18)
                                        <td>{{$round->score('in')}}</td>
                                        <td>{{$round->score('total')}}</td>
                                    @endif
                                @endfor
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
