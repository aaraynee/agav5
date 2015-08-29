<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model {

    public $timestamps = false;

    protected $guarded = [];

    public function tournament() {
        return $this->belongsTo('App\Tournament');
    }

    public function player() {
        return $this->belongsTo('App\Player');
    }

    public function getHolesPlayedAttribute() {
      return count(explode(" ", $this->attributes['scorecard']));
    }

    public function getScoreArrayAttribute() {
        return explode(" ", $this->attributes['scorecard']);
    }

    public function get_score($get = 'total') {
        $scorecard = explode(" ", $this->attributes['scorecard']);

        if($get == 'out') {
            $scorecard = array_sum(array_slice($scorecard, 0,9));
        }elseif($get == 'in') {
            $scorecard = array_sum(array_slice($scorecard, 9,9));
        }else {
            $scorecard = array_sum(array_slice($scorecard, 0,18));
        }

        return $scorecard;
    }

    public function score_class() {
        $classes = [
            '-2' => 'eagle',
            '-1' => 'birdie',
            '0' => 'par',
            '1' => 'bogey',
            '2' => 'dblbogey',
            '3' => 'tplbogey',
        ];
        $scorecard = explode(" ", $this->attributes['scorecard']);
        for($i = 1; $i <= $this->holes_played; $i++) {
            $score = $scorecard[$i-1] - $this->tournament->course->scorecard_array['par'][$i];
            if($score > 3) {
                $score = 3;
            }
            $class_array[$i] = $classes[$score];
        }
      return $class_array;
    }

    public function getScoreboardAttribute() {
      return (isset($this->attributes['adjusted']) ? (($this->attributes['adjusted'] == 0) ? "E" : sprintf("%+d",$this->attributes['adjusted'])) : sprintf("%+d",$this->attributes['total']));
    }

    public function getScoreboardTotalAttribute() {
      return (($this->attributes['total'] == 0) ? "E" : sprintf("%+d",$this->attributes['total']));
    }
}
