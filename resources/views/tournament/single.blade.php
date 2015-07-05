@extends('layouts.master')

@section('content')

<style>
    .scoreboard {font-size: 18px; margin:0 padding:0;}
    .scoreboard thead tr td { background: #F0F0F0; color: #000000; font-size: 15px; padding: 10px 0px; text-transform: uppercase; font-weight: 700; text-align: center;}
    .scoreboard tbody tr td { text-align: center; height: 30px; vertical-align: middle; border-bottom: 1px solid #e9e9e9; border-left: 1px solid #e9e9e9; }
    .scoreboard .player { text-align:left; }
    .scoreboard tr:nth-child(even) {background: #f2f2f2}
    .scoreboard tr:nth-child(odd) {background: #f7f7f7}

    .scoreboard span {
        margin: 5px 0;

}
    .scoreboard span.name {
        display:block;
font-weight: 700;
  font-size: 20px;}

  .scoreboard span.country {
      display:block;
      font-size: 16px;
  height: 20px;
  line-height: 20px;
  }

  .scoreboard span.handicap {
      display:block;
      font-size: 16px;
      background: #003865;
      color: #ffffff;
      padding: 4px 10px;
  height: 20px;
  line-height: 20px;
  }

    .scorecard {font-weight: normal;
  font-size: 14px;
  border-left: 1px solid #e9e9e9;
  border-right: 1px solid #e9e9e9;}
    /*.scorecard tr td {  height: 14px; line-height: 14px;}*/
    .scorecard tr.par td {border-top: 5px solid #c7c7c7;}

    .scorecard .eagle, .eagle { background-color: #156399; color: #FFFFFF; }
    .scorecard .birdie, .birdie { background-color: #99D7E8; }
    .scorecard .par, .par { background-color: #FFFFFF; }
    .scorecard .bogey, .bogey { background-color: #F7B540; }
    .scorecard .dblbogey, .dblbogey { background-color: #F55D00; color: #FFFFFF; }
    .scorecard .tplbogey, .tplbogey { background-color: #A50D00; color: #FFFFFF; }

    .scoreboard tr td img {
        width: 200px;
    }

    .legend td span { float: left; width: 18px; height: 18px; margin-right: 10px; }

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
                    <td>
                        {!!$round->player->photo!!}
                        <span class="name">{{$round->player->name}}</span>
                        <span class="country">{{$round->player->country}}</span>
                        <span class="handicap">Handicap {{$round->player->handicap($round->tournament->date)}}</span>
                    </td>
                    <td colspan="7">
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
                        <table class="uk-table legend">
                            <tr>
                                <td><span class="eagle"></span>Eagle&nbsp;or&nbsp;better</td>

                                <td><span class="birdie"></span>Birdie</td>

                                <td><span class="par"></span>Par</td>

                                <td><span class="bogey"></span>Bogey</td>

                                <td><span class="dblbogey"></span>Double&nbsp;Bogey</td>

                                <td><span class="tplbogey"></span>Triple&nbsp;Bogey&nbsp;or&nbsp;worse</td>

                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
