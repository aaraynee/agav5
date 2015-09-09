<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Season;
use App\Round;
use App\Player;
use App\Stat;
use App\Tournament;

class Tournaments extends Command {

    protected $name = 'tournaments';

    protected $description = 'Command description.';

    public function __construct()
    {
        parent::__construct();
    }


    public function fire()
    {
        $tournaments = Tournament::all();
        foreach($tournaments as $tournament) {
            $this->info("--------------------");
            $this->info($tournament->name);
            $this->info("--------------------");

            if($tournament->scoring == 'stroke' && $tournament->completed != 1) {

                $tournament_scores = [];

                $i = 1;
                foreach ($tournament->rounds as $round) {
                    if(empty($round->adjusted)) {
                        $score = $round->strokes;
                    } else {
                        $score = $round->adjusted;
                    }

                    $tournament_scores[$round->id] = $score;
                    $i++;
                }

                asort($tournament_scores);

                $i = 1;
                $last_score = array_count_values($tournament_scores);
                $last = reset($tournament_scores);

                $tournament_positions = [];

                foreach ($tournament_scores as $round_id => $score) {

                    $round = Round::find($round_id);

                    if ($last != $score) {
                        $round->position = $i = $i + $last_score[$last];
                    } else {
                        $round->position = $i;
                    }

                    $tournament_positions[$round_id] = $round->position;
                    if ($round->status = 2) {
                        $round->status = 3;
                        $round->save();
                    }

                    $last = $score;
                }


                if ($tournament->points == 2500) {
                    $points_array = [2500, 1500, 950, 675, 550, 500, 450, 425, 400, 375, 350, 320, 300, 285, 280];
                } elseif ($tournament->points == 2000) {
                    $points_array = [2000, 1200, 760, 540, 440, 400, 360, 340, 320, 300, 280, 260, 240, 228, 224];
                } elseif ($tournament->points == 1000) {
                    $points_array = [1000, 600, 380, 270, 220, 200, 180, 170, 160, 150, 140, 130, 120, 114, 112];
                } elseif ($tournament->points == 500) {
                    $points_array = [500, 300, 190, 135, 110, 100, 90, 85, 80, 75, 70, 65, 60, 57, 56];
                } elseif ($tournament->points == 50) {
                    $points_array = [50, 30, 19, 13, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1];
                } else {
                    $points_array = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                }

                $last_position = array_count_values($tournament_positions);
                $last = reset($tournament_positions);

                foreach ($tournament_positions as $round_id => $position) {

                    $round = Round::find($round_id);

                    if(empty($round->adjusted)) {
                        $score = $round->strokes;
                    } else {
                        $score = $round->adjusted;
                    }

                    $points = 0;

                    for ($i = $position; $i < $position + $last_position[$position]; $i++) {
                        $points += $points_array[$i - 1];
                    }

                    $points = round($points / $last_position[$position], 0);

                    $this->info("$position - $score ($points)");
                    $last = $position;

                    $round->points = $points;

                    if ($round->status = 3) {
                        $round->status = 4;
                        $round->save();
                    }
                }
            }

            $tournament->completed = 1;
            $tournament->save();
        }
    }
}
