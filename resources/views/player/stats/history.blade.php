   <table class="uk-table stats">
        <thead>
        </thead>
        <tbody>
            <tr>
                <th></th>
                @foreach($stats['made'] as $made)
                <th>{{$made}}</th>
                @endforeach
            </tr>
            @foreach($player->stats_array['score_array']->made as $time => $stat)
                <tr>
                    <th>{{$time}}</th>
                    @foreach($stat as $total)
                        <td>
                            @if($total>0)
                                {{$total}}
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="uk-table stats">
        <thead>
        </thead>
        <tbody>
            <tr>
                <th>Distance</th>
                @foreach($stats['distance'] as $label => $distance)
                    <th colspan="{{count($distance)}}">{{$label}}</th>
                @endforeach
            </tr>
            <tr>
                <th>Par</th>
                @foreach($stats['distance'] as $distance)
                    @foreach($distance as $par)
                    <th>{{$par}}</th>
                    @endforeach
                @endforeach
            </tr>
            @foreach($player->stats_array['score_array']->distance as $time => $stats)
                <tr>
                    <th>{{$time}}</th>
                    @foreach($stats as $par)
                        @foreach($par as $average)
                            <td>
                                @if($average > 0)
                                    {{$average}}
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
