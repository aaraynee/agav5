<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Season;
use App\Player;
use App\Stat;

class Seasons extends Command {

	protected $name = 'seasons';

	protected $description = 'Command description.';

	public function __construct()
	{
		parent::__construct();
	}


	public function fire()
	{
		$seasons = Season::all();
		$players = Player::all();
        
        foreach($players as $player) {
            $this->info('------------');           
            $this->info($player->name);
            $this->info('------------');
            
            foreach($seasons as $season) {
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
                        && $round->tournament->scoring == 'stroke'
                        && $round->tournament->type == 2
                        && $round->tournament->season_id == $season->id
                      ) {
                        
                        if(!$round->points) {
                            $round->points = 0;
                        }
                        $stats_array['points']['total'] += $round->points;
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
                    if(date('Y-m-d', strtotime($date)) < date('Y-m-d', strtotime('-3 month'))) {
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
            
            foreach($current[$season->id] as $player_id => $points) {
                if($position == 0) {
                    $position++;
                } elseif($points != $last_points) {
                    $position += $draw[$points];
                }
                
                $last_points = $points;
                
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
        }
	}
}