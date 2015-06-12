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
                        Dashboard.showYear(this);
                    });
                },
                showYear: function(link) {
                    var year = $(link).attr('data-id');
                    $('tr.season'+year).removeClass('uk-hidden');                    
                }
            }
</script>

@foreach($seasons as $season) 
    <a class="year" href="javascript:;" data-id="{{$season->id}}">{{$season->year}}</a>
@endforeach

<table class="uk-table">
    <thead>
        <tr>
            <th></th>
            <th>Position</th>
            <th>Score</th>
            <th>Total</th>
            <th>Adjusted</th>
            <th>Points</th>
        </tr>
    </thead>
    <tbody>
        @foreach($player->rounds as $round)
            <tr class="tournament season{{$round->tournament->season_id}}">
                <td>{{$round->tournament->name}}</td>
                <td>{{$round->position}}</td>
                <td>{{$round->score}}</td>
                <td>{{$round->total}}</td>
                <td>{{$round->adjusted}}</td>
                <td>{{$round->points}}</td>
            </tr>
        @endforeach
    </tbody>    
</table>