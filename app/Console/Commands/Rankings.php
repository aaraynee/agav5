<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Season;
use App\Player;
use App\Stat;
use App\Tournament;
use Carbon\Carbon;


class Rankings extends Command {

	protected $name = 'rankings';

	protected $description = 'Command description.';

	public function __construct()
	{
		parent::__construct();
	}


	public function fire()
	{
		$tournaments = Tournament::all();
		$seasons = Season::all();
		$players = Player::all();

        foreach($players as $player) {
            $this->info('------------');
            $this->info($player->name);
            $this->info('------------');

			$stats_array = [
				'played' => 0,
				'points' => ['total' => 0, 'last' => 0],
				'wins' => 0,
				'top2' => 0,
				'points_history' => []
			];

            $history = array();
            foreach($player->rounds as $round) {
                if($round->holes_played == 18
					&& $round->tournament->date >= date('Y-m-d', strtotime('-8 months'))
                    && $round->tournament->scoring == 'stroke'
					&& ($round->tournament->type == 'tour'
                    || $round->tournament->type == 'exhibition')
                  ) {

                    if(!$round->points) {
                        $round->points = 0;
                    }

					$date = new Carbon($round->tournament->date);
					$now = new Carbon();

					$multiplier = (($round->tournament->type == 'tour') ? 0.25 : 0.5);

					$ratio = ((8*30) - $date->diffInDays($now))/(8*30);

					$rating = intval(($multiplier/$round->position)*(10*$ratio));

                    $stats_array['points']['total'] += $rating;
                    $stats_array['points_history'][$round->tournament->date] = $stats_array['points']['total'];
                    $stats_array['played']++;

                    if($round->position < 3) {
                        if($round->position == 1) {
                            $stats_array['wins']++;
                        }
                        $stats_array['top2']++;
                    }
                }
            }

            krsort($stats_array['points_history']);

            foreach($stats_array['points_history'] as $date => $total_points) {
                if(date('Y-m-d', strtotime($date)) < date('Y-m-d', strtotime('-1 month'))) {
                    $stats_array['points']['last'] = $total_points;
                    break;
                }
            }

            foreach($stats_array as $stat => $value) {

                if(!empty($value)) {
                    $details = [
                        'label' => $stat,
                        'player_id' => $player->id,
                    ];
                    $update = Stat::firstOrNew($details);
                    $update->json = json_encode($value);
                    $update->save();
                    $details = array();
                }
            }

            $current[$player->id] = $stats_array['points']['total'];
            $last[$player->id] = $stats_array['points']['last'];
        }


        $stats_array = [];
        $current = array_diff($current, array('', 0));
        arsort($current);

        $position = 0;
        $last_points = -9999;

        $draw = array_count_values($current);

        foreach($current as $player_id => $points) {
            if($position == 0) {
                $position++;
            } elseif($points != $last_points) {
                $position += $draw[$last_points];
            }

            $last_points = $points;

            $stats_array[$player_id]['position']['total'] = $position;
        }


        $last = array_diff($last, array('', 0));
        arsort($last);

        $position = 0;
        $last_points = -9999;
        $draw = array_count_values($last);

        foreach($last as $player_id => $points) {
            if($position == 0) {
                $position++;
            } elseif($points != $last_points) {
                $position += $draw[$last_points];
            }

            $last_points = $points;

            $stats_array[$player_id]['position']['last'] = $position;
        }

        foreach($stats_array as $player_id => $stats) {
            foreach($stats as $stat => $value) {
                if(!empty($value)) {
                    $details = [
                        'label' => $stat,
                        'player_id' => $player_id,
                    ];
                    $update = Stat::firstOrCreate($details);
                    $update->json = json_encode($value);
                    $update->save();
                    $details = array();
                }
            }
        }
	}
}
