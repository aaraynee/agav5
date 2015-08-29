<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Season;
use App\Round;
use App\Player;
use App\Stat;
use App\Tournament;

class Rounds extends Command {

    protected $name = 'rounds';

    protected $description = 'Command description.';

    public function __construct()
    {
        parent::__construct();
    }


    public function fire()
    {
        $players = Player::all();
        foreach($players as $player) {
            $this->info("--------------------");
            $this->info("{$player->firstname} {$player->lastname}");
            $this->info("--------------------");

            $total_rounds = count($player->rounds);
            $this->comment("{$total_rounds} ROUNDS");

            $i = 1;
            foreach($player->rounds as $round) {
                if($round->status == 0) {
                    $this->process($round);
                    $round->status = $this->comment("PROCESSING {$i} of {$total_rounds} ({$round->id})");
                } elseif($round->status == 1 && $round->holes_played == 18) {
                    $this->calculate($round, $player);
                    $round->status = $this->comment("PROCESSING {$i} of {$total_rounds} ({$round->id})");
                }
                $i++;
            }

        }
    }

    public function process($round) {

        if(!empty($round->scorecard) && $round->scorecard != '') {
            $total = array_sum($round->score_array);
            $round->strokes = $total;

            if ($round->holes_played == 18) {
                $par = array_sum($round->tournament->course->scorecard_array['par']);
                $round->total = $total - $par;
                $round->status = 1;
            } else {
                $par = array_sum(array_slice($round->tournament->course->scorecard_array['par'], 0, 9));
                $round->total = $total - $par;
                $round->adjusted = NULL;
                $round->handicap = NULL;
                $round->status = 2;
            }
            $round->save();
        } else {
            $round->strokes = NULL;
            $round->total = NULL;
            $round->adjusted = NULL;
            $round->handicap = NULL;
            $round->save();
        }
        return $round->status;
    }

    public function calculate($round, $player) {
        if(!empty($round->scorecard) && $round->scorecard != '' && $round->tournament->scoring == 'stroke') {
            $handicap_score = round(($round->strokes - $round->tournament->course->scratch_rating) * (113/$round->tournament->course->slope_rating), 1);
            $round->handicap = (($handicap_score > 40) ? 40 : $handicap_score);
            $round->adjusted = $round->total - ($this->handicap($player->id, $round->tournament->date) * ($round->tournament->course->slope_rating/113));
            $round->status = 2;
            $round->save();
        } elseif($round->tournament->scoring != 'stroke') {
            $round->handicap = NULL;
            $round->adjusted = NULL;
            $round->save();
        }
        return TRUE;
    }

    public function handicap($player_id, $date = NULL) {

        if(!$date) {
            $date = date('Y-m-d');
        } else {
            $date = date('Y-m-d', strtotime($date));
        }

        $rounds =  Round::where('player_id', $player_id)->whereHas('tournament', function ($query) use ($date) {
            $query->where('date', '<', $date)->where('scoring', 'stroke');
        })->get();

        $handicap_rounds = array();
        foreach($rounds as $round) {
            if($round->holes_played == 18) {
                if(count($handicap_rounds) == 20) {
                    $handicap_rounds = array_slice($handicap_rounds, 1, 19);
                }
                $handicap_rounds[] = $round->handicap;
            }
        }

        asort($handicap_rounds);
        $total_handicap_rounds = count($handicap_rounds);

        if($total_handicap_rounds < 3) {
            $rounds_to_count = 0;
        } elseif($total_handicap_rounds <= 6) {
            $rounds_to_count = 1;
        } elseif($total_handicap_rounds <= 8) {
            $rounds_to_count = 2;
        } elseif($total_handicap_rounds <= 10) {
            $rounds_to_count = 3;
        } elseif($total_handicap_rounds <= 12) {
            $rounds_to_count = 4;
        } elseif($total_handicap_rounds <= 14) {
            $rounds_to_count = 5;
        } elseif($total_handicap_rounds <= 16) {
            $rounds_to_count = 6;
        } elseif($total_handicap_rounds <= 18) {
            $rounds_to_count = 7;
        } else {
            $rounds_to_count = 8;
        }

        if($rounds_to_count == 0) {
            $handicap = 36.0;
        } else {
            $handicap = 0.93 * (array_sum(array_slice($handicap_rounds, 0 , $rounds_to_count)) / $rounds_to_count);
            if($handicap > 36.4) {
                $handicap = 36.4;
            }
        }

        return sprintf("%0.1f",$handicap);
    }
}
