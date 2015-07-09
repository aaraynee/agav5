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
				'rankings_played' => 0,
				'rankings_points' => ['total' => 0, 'last' => 0],
				'rankings_wins' => 0,
				'rankings_top2' => 0,
				'rankings_points_history' => []
			];

            $history = array();
            foreach($player->rounds as $round) {
                if($round->holes_played == 18
					&& $round->tournament->date >= date('Y-m-d', strtotime('-8 months'))
                    && $round->tournament->scoring == 'stroke'
					&& ($round->tournament->type == 'tour'
                    || $round->tournament->type == 'exhibition')
                  ) {
					$total_players = 0;
					$handicap_total = 0;
					foreach($round->tournament->rounds as $round1) {
						$handicap_total += $round1->player->handicap($round->tournament->date);
						$total_players++;
					}
                    if(!$round->points) {
                        $round->points = 0;
                    }

					$date = new Carbon($round->tournament->date);
					$now = new Carbon();

					$a = ($total_players/$round->position);
					$b = 36.4 / ($handicap_total/$total_players);
					$c = (10*((((8*30)+1) - $date->diffInDays($now))/(8*30)));
					$d = (($round->tournament->type == 'tour') ? 10 : 1);

					$rating = intval($a * $b * $c * $d);

                    $stats_array['rankings_points']['total'] += $rating;
                    $stats_array['rankings_points_history'][$round->tournament->date] = $stats_array['rankings_points']['total'];
                    $stats_array['rankings_played']++;

                    if($round->position < 3) {
                        if($round->position == 1) {
                            $stats_array['rankings_wins']++;
                        }
                        $stats_array['rankings_top2']++;
                    }
                }
            }

            krsort($stats_array['rankings_points_history']);
			$minus = 0;
            foreach($stats_array['rankings_points_history'] as $date => $total_points) {
				$minus++;
                if(date('Y-m-d', strtotime($date)) < date('Y-m-d', strtotime('-1 month'))) {
                    $stats_array['rankings_points']['last'] = $total_points;
                    break;
                }
            }

			$average = $stats_array['rankings_played'];
			if($average > 30) {
				$average = 30;
			}elseif($average <= 0) {
				$average = 1;
			}
			$average_last = $stats_array['rankings_played'] - $minus;
			if($average_last > 30) {
				$average_last = 30;
			}elseif($average_last <= 0) {
				$average_last = 1;
			}
            $current[$player->id] = $stats_array['rankings_points']['total'] = intval($stats_array['rankings_points']['total']/$average);
            $last[$player->id] = $stats_array['rankings_points']['last'] = intval($stats_array['rankings_points']['last']/$average_last);

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

            $stats_array[$player_id]['rankings_position']['total'] = $position;
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

            $stats_array[$player_id]['rankings_position']['last'] = $position;
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
