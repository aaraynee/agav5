<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use HTML;
use Carbon\Carbon;

class Player extends Model {

    public $timestamps = false;

    protected $guarded = [];

    public function rounds() {
        return $this->hasMany('App\Round');
    }

    public function stats() {
        return $this->hasMany('App\Stat');
    }

    public function getNameAttribute() {
      return "{$this->attributes['firstname']} {$this->attributes['lastname']}";
    }

    public function getFullnameAttribute() {
      return "{$this->attributes['lastname']}, {$this->attributes['firstname']}";
    }

    public function getAgeAttribute() {
        $carbon = new Carbon($this->attributes['dob']);
        return $carbon->age;
    }

    public function getPhotoAttribute() {
        $lastname = strtolower($this->attributes['lastname']);
        return HTML::image("img/players/".strtolower($this->attributes['lastname']) . ".png", "{$this->attributes['firstname']} {$this->attributes['lastname']}", ['width'=>"630px",'height'=>"385px"]);
    }

    public function getFlagAttribute() {
        return "<span class='flag-icon flag-icon-{$this->attributes['country_code']}'></span>";
    }

    public function getStatsArrayAttribute() {
        foreach($this->stats as $stat) {
            $stats_array[$stat->label] = json_decode($stat->json);
        }
        return $stats_array;
    }

    public function handicap($date = NULL) {

        if(!$date) {
            $date = date('Y-m-d');
        } else {
            $date = date('Y-m-d', strtotime($date));
        }

        $rounds =  Round::where('player_id', $this->id)->whereHas('tournament', function ($query) use ($date) {
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
