<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Season;
use App\Player;
use App\Stat;
use App\Tournament;

class Seasons extends Command {

	protected $name = 'seasons';

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

		foreach($tournaments as $tournament) {
			foreach($seasons as $season) {
				if(date('Y-m-d', strtotime($tournament->date)) >= $season->start_date
				&& date('Y-m-d', strtotime($tournament->date)) <= $season->end_date) {
					$tournament->season_id = $season->id;
					$tournament->save();
					break;
				}
			}
		}

        foreach($players as $player) {
            foreach($seasons as $season) {
                $stats_array = [
                    'played' => 0,
                    'points' => ['total' => 0, 'last' => 0],
                    'wins' => 0,
                    'top2' => 0,
                    'points_history' => []
                ];
                $reset[$season->id][$player->id] = 0;

                $history = array();
                foreach($player->rounds as $round) {
                    if($round->holes_played == 18
                        && $round->tournament->scoring == 'stroke'
                        && $round->tournament->type == 'tour'
                        && $round->tournament->season_id == $season->id
                      ) {

                        if(!$round->points) {
                            $round->points = 0;
                        }

                        if(!$round->tournament->reset) {
                            $stats_array['points']['total'] += $round->points;
                            $stats_array['points_history'][$round->tournament->date] = $stats_array['points']['total'];
                        } else {
                            $reset[$season->id][$player->id] = $round->points;
                        }
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
                            'season_id' => $season->id,
                        ];
                        $update = Stat::firstOrCreate($details);
                        $update->json = json_encode($value);
                        $update->save();
                        $details = array();
                    }
                }

                $current[$season->id][$player->id] = $stats_array['points']['total'];
                $last[$season->id][$player->id] = $stats_array['points']['last'];
            }
        }

        foreach($seasons as $season) {

            $stats_array = [];

            $current[$season->id] = array_diff($current[$season->id], array('', 0));
            arsort($current[$season->id]);

            $position = 0;
            $last_points = -9999;
            $draw = array_count_values($current[$season->id]);

            $reset_points_array = array(0,2500,2000,1500,1000,750,500,250,125,100,90,80,70);

            foreach($current[$season->id] as $player_id => $points) {
                if($position == 0) {
                    $position++;
                } elseif($points != $last_points) {
                    $position += $draw[$points];
                }

                $last_points = $points;

                $reset_array[$player_id] = $reset[$season->id][$player_id] + $reset_points_array[$position];
                $stats_array[$player_id]['position']['total'] = $position;
            }


            $last[$season->id] = array_diff($last[$season->id], array('', 0));
            arsort($last[$season->id]);

            $position = 0;
            $last_points = -9999;
            $draw = array_count_values($last[$season->id]);

            foreach($last[$season->id] as $player_id => $points) {
                if($position == 0) {
                    $position++;
                } elseif($points != $last_points) {
                    $position += $draw[$points];
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
                            'season_id' => $season->id,
                        ];
                        $update = Stat::firstOrCreate($details);
                        $update->json = json_encode($value);
                        $update->save();
                        $details = array();
                    }
                }
            }


            /* RESET */
            $stats_array = [];
            arsort($reset_array);

            $position = 0;
            $last_points = -9999;
            $draw = array_count_values($reset_array);

            foreach($reset_array as $player_id => $points) {
                if($position == 0) {
                    $position++;
                } elseif($points != $last_points) {
                    $position += $draw[$points];
                }

                $last_points = $points;

                $stats_array[$player_id]['reset']['points'] = $points;
                $stats_array[$player_id]['reset']['position'] = $position;
            }

            foreach($stats_array as $player_id => $stats) {
                foreach($stats as $stat => $value) {
                    if(!empty($value)) {
                        $details = [
                            'label' => $stat,
                            'player_id' => $player_id,
                            'season_id' => $season->id,
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
}
