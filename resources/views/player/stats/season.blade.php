<style>

    .tabs-row { width: 998px; height: 69px; background-color: #EFEFEF; position: relative; float: left; border-bottom: solid 1px #FFFFFF; }
    .tabs-row .border { background: #D8D8D8; width: 100%; height: 1px; position: absolute; bottom: 0; left: 0; z-index: 0; }
    .tabs-row .tab { position: relative; font-family: "AlegreyaSans", Arial, Helvetica, sans-serif; font-weight: normal; font-size: 18px; height: 69px; text-transform: uppercase; border-right: #E3E3E3 1px solid; float: left; }
    .tabs-row .tab:first-child { margin-left: 0px; left: -1px; }
    .tabs-row .tab:first-child.selected a:before { width: 0; background: none; }
    .tabs-row .tab a { display: block; padding: 20px; color: #474c56; }
    .tabs-row .tab.selected { background: #F7F7F7; top: -9px; padding-bottom: 9px; border-bottom: solid 1px #f7f7f7; border-right: 1px solid #D8D8D8; z-index: 1; }
    .tabs-row .tab.selected a { color: #000000; cursor: default; font-family: "AlegreyaSans Bold", Arial, Helvetica, sans-serif; font-weight: 700; padding: 29px 20px 29px 20px; }
    .tabs-row .tab.selected a:before { content: ""; background-image: url(/images/nav/tab_selected_sprite.png); background-position: -28px 0px; position: absolute; width: 18px; height: 60px; display: block; top: 9px; left: -18px; z-index: 1; }
    .tabs-row .tab.selected a:after { content: ""; background-image: url(/images/nav/tab_selected_sprite.png); background-position: 0px 0px; position: absolute; width: 18px; height: 60px; display: block; top: 9px; right: -18px; z-index: 1; }
    .tabs-row .tab.disabled a { color: #8D8D8D; cursor: default; }
    .tabs-row .label { font-size: 9px; text-transform: uppercase; margin-right: 10px; }
    .tabs-row .option { float: right; margin-right: 10px; font-size: 14px; line-height: 30px; height: 30px; color: #474c56; }
    .tabs-row .option #help { margin-top: 7px; display: block; width: 15px; height: 15px; background: url("/images/misc/misc_sprites_2014.png") -16px -65px no-repeat transparent; }
    .tabs-row .option label { font-family: "AlegreyaSans", Arial, Helvetica, sans-serif; font-weight: normal; font-size: 16px; }
    .tabs-row.subnav { background-color: #E3E3E3; height: auto; *zoom: 1; clear: both; float: none; border-top: solid 1px #FFFFFF; border-bottom: solid 1px #FFFFFF; }
    .tabs-row.subnav:before, .tabs-row.subnav:after { content: ""; display: table; }
    .tabs-row.subnav:after { clear: both; }
    .section-links + .tabs-row.subnav { border-top: 0; }
    .tabs-row.subnav .tab { font-family: "AlegreyaSans Bold", Arial, Helvetica, sans-serif; font-weight: 700; font-size: 16px; height: auto; padding-bottom: 0; }
    .tabs-row.subnav .tab:first-child { left: 0; }
    .tabs-row.subnav .tab a { padding: 10px 20px; cursor: pointer; }
    .tabs-row.subnav .tab.disabled a { cursor: default; }
    .tabs-row.subnav .tab.selected { background-color: #353a40; top: 0; border-bottom: 0; }
    .tabs-row.subnav .tab.selected a { color: #FFFFFF; padding: 10px 20px; }
    .tabs-row.subnav .tab.selected a:before, .tabs-row.subnav .tab.selected a:after { background: none; width: 0; }
    .tabs-row.subnav .tab.selected .hidden { display: none; }


</style>

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

<script>
    $(function(){
        Dashboard.init();
    });

    var Dashboard = {
        el: {
        },
        init: function(){

            var tournaments = $('tr.tournament');

            tournaments.addClass('uk-hidden');
            $('tr.season{{$current_season->id}}').removeClass('uk-hidden');

            $('a.year').click(function(){
                tournaments.addClass('uk-hidden');
                $('div.tab').removeClass('selected');
                Dashboard.showYear(this);
            });
        },
        showYear: function(link) {
            var year = $(link).attr('data-id');
            $('tr.season'+year).removeClass('uk-hidden');
            $(link).parent('div.tab').addClass('selected');
            $('tr.round').addClass('uk-hidden');
        }
    }
</script>

<div class="tabs-row subnav">
    @foreach($seasons as $season)
        <div class="tab"><a class="year" href="javascript:;" data-id="{{$season->id}}">{{$season->year}}</a></div>
    @endforeach
</div>

<table class="uk-table">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Position</th>
            <th>Total</th>
            <th>Adjusted</th>
            <th>Points</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($player->rounds as $round)
            <tr class="tournament season{{$round->tournament->season_id}}">
                <td>{{$round->tournament->short_date}}</td>
                <td>{{$round->tournament->name}}</td>
                <td>{{$round->position}}</td>
                <td>{{$round->scoreboard_total}}</td>
                <td>{{$round->scoreboard}}</td>
                <td>{{$round->points}}</td>
                <td><i class="uk-icon-plus-square-o uk-icon-justify" id="{{$round->id}}-plus" data-uk-toggle="{target:'#{{$round->id}}, #{{$round->id}}-plus, #{{$round->id}}-minus',animation:'uk-animation-slide-left'}"></i>
                    <i class="uk-icon-minus-square-o uk-icon-justify uk-hidden" id="{{$round->id}}-minus" data-uk-toggle="{target:'#{{$round->id}}, #{{$round->id}}-plus, #{{$round->id}}-minus'}"></i>
                </td>
            </tr>
            <tr id="{{$round->id}}" class="uk-hidden round">
                <td colspan="7">
                    <table class="uk-table scorecard">
                        <tr>
                            <td>Hole</td>
                            @for($i =1;$i<=$round->holes_played;$i++)
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
                            @for($i =1;$i<=$round->holes_played;$i++)
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
                            @for($i =1;$i<=$round->holes_played;$i++)
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
                            @for($i =1;$i<=$round->holes_played;$i++)
                                <td class="{{$round->score_class()[$i]}}">{{$round->score_array[$i-1]}}</td>
                                @if($i == 9)
                                    <td>{{$round->get_score('out')}}</td>
                                @elseif($i == 18)
                                    <td>{{$round->get_score('in')}}</td>
                                    <td>{{$round->get_score('total')}}</td>
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
