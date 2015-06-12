<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Stat;
use App\Round;
use App\Player;

class Stats extends Command {

	protected $name = 'stats';

	protected $description = 'Update all player stats';
    
    public $times = array(
        'last month' => '-1 months', 
        'last 3 months' => '-3 months', 
        'last 6 months' => '-6 months',
        'all time' => '-10 years', 
    );

    public $made = array(
        'eagles' => -2, 
        'birdies' => -1, 
        'pars' => -0, 
        'bogeys' => 1, 
        'double bogeys' => 2, 
        'triple bogeys' => 3
    );
    
    public $distance = array(
            '150' => array(3), 
            '200' => array(3), 
            '250' => array(4), 
            '350' => array(4,5), 
            '400' => array(4,5), 
            '450' => array(4,5), 
            '500' => array(5), 
            '575' => array(5)
    );    

	public function __construct()
	{
		parent::__construct();
	}

	public function fire()
	{
        $players = Player::all();
        foreach($players as $player) {
            
            $rounds_played = 0;
            $courses_played = array();
            $score_array = array();
            $all_rounds = array();
            
            
            $stat_exists['rounds_played'] = FALSE;
            $stat_exists['courses_played'] = FALSE;
            $stat_exists['all_rounds'] = FALSE;
            $stat_exists['score_array'] = FALSE;
            
            $this->comment($player->name);
            $this->comment('------------------');
                        
            foreach($this->times as $time_label => $time) {
                foreach($this->made as $made_label => $stat) {
                    $score_array['made'][$time_label][$made_label] = 0;
                } 
                foreach($this->distance as $distance_label => $pars) {
                    foreach($pars as $par) {
                        $score_array['distance'][$time_label][$distance_label][$par] = 0;
                        $temp['distance'][$time_label][$distance_label][$par] = array();
                    }
                }                   
            }
            
            foreach($player->rounds as $round) {
                if($round->holes_played == 18 && $round->tournament->scoring == 'stroke') {
                    $rounds_played++;
                    debug(1);
                    $hole = 1;
                    $scorecard = array();
                    $course_scorecard = $round->tournament->course->scorecard_array;
                    
                    foreach($round->score_array as $score) {
                        foreach($this->times as $time_label => $time) {
                            $date = date('Y-m-d', strtotime($time));
                            if(date('Y-m-d', strtotime($round->tournament->date)) >= $date) {
                                foreach($this->made as $made_label => $stat) {
                                    if($stat == $score - $course_scorecard['par'][$hole] 
                                      || ($stat == 3 && ($score - $course_scorecard['par'][$hole]) > 3)) {
                                        $score_array['made'][$time_label][$made_label]++;
                                        break;
                                    }
                                }
                                foreach($this->distance as $distance_label => $pars) {
                                    
                                    if($round->tournament->course->unit == 1) {
                                        $course_scorecard['distance'][$hole] *= 0.9144;
                                    }
                                    
                                    if($course_scorecard['distance'][$hole] <= $distance_label) {
                                        $temp['distance'][$time_label][$distance_label][$course_scorecard['par'][$hole]][] = $score;
                                        break;                                       
                                    }
                                }                                
                            }
                        }
                        $hole++;
                    }
                    
                    foreach($this->times as $time_label => $time) {

                        foreach($this->distance as $distance_label => $pars) {
                            foreach($pars as $par) {
                                $total = $temp['distance'][$time_label][$distance_label][$par];
                                if(count($total) > 0) {
                                        $score_array['distance'][$time_label][$distance_label][$par] = sprintf("%0.1f",array_sum($total)/count($total));
                                }
                            }
                        }                   
                    }                    
                                        
                    if($round->handicap != NULL) {
                        $all_rounds[$round->tournament->date]['handicap'] = $round->handicap;
                    }
                    if($round->points != NULL) {
                        $all_rounds[$round->tournament->date]['points'] = $round->points;
                    } 
                    if($round->adjusted != NULL) {
                        $all_rounds[$round->tournament->date]['adjusted'] = $round->adjusted;
                    }
                    if($round->position != NULL) {
                        $all_rounds[$round->tournament->date]['position'] = $round->position;
                    }                      
                }
                if(!in_array($round->tournament->course->id, $courses_played)) {
                    $courses_played[] = $round->tournament->course->id;
                }
            }
            
            ksort($all_rounds);

            foreach($player->stats as $stat) {
                if($stat->label == 'rounds_played') {
                    $stat_exists['rounds_played'] = TRUE;  
                }                
                if($stat->label == 'courses_played') {
                    $stat_exists['courses_played'] = TRUE;  
                }      
                if($stat->label == 'all_rounds') {
                    $stat_exists['all_rounds'] = TRUE;  
                }  
                if($stat->label == 'score_array') {
                    $stat_exists['score_array'] = TRUE;  
                }  
            }
            
            /* ROUNDS PLAYED */
            if(!$stat_exists['rounds_played']) {
                $stat = new Stat;
                $stat->player_id = $player->id;
                $stat->label = 'rounds_played';
            }
            
            $stat->json = json_encode($rounds_played);            
            $stat->save();

            /* COURSES PLAYED */
            if(!$stat_exists['courses_played']) {
                $stat = new Stat;
                $stat->player_id = $player->id;
                $stat->label = 'courses_played';
            }
            
            $stat->json = json_encode(count($courses_played));            
            $stat->save();
            
             /* COURSES PLAYED */
            if(!$stat_exists['all_rounds']) {
                $stat = new Stat;
                $stat->player_id = $player->id;
                $stat->label = 'all_rounds';
            }
            
            $stat->json = json_encode($all_rounds);            
            $stat->save();

             /* SCORE ARRAY */
            if(!$stat_exists['score_array']) {
                $stat = new Stat;
                $stat->player_id = $player->id;
                $stat->label = 'score_array';
            }
            
            $stat->json = json_encode($score_array);            
            $stat->save();
            
            $this->info('Stats updated');
            $this->comment('------------------');
        }
	}
}
