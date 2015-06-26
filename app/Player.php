<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use HTML;
use Carbon\Carbon;

class Player extends Model {

    public $timestamps = false;

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
        return HTML::image("img/players/default.png", "{$this->attributes['firstname']} {$this->attributes['lastname']}", ['width'=>"630px",'height'=>"385px"]);
    }

    public function getFlagAttribute() {
        $country = strtolower($this->attributes['country']);
        return HTML::image("img/flags/{$country}.gif");
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
        }
        $rounds =  $this->stats_array['all_rounds'];

        $handicap_rounds = array();

        foreach($rounds as $round_date => $round) {
            if($round_date <= $date) {
                $handicap_rounds[] = $round->handicap;
            }
        }

        $handicap_rounds = array_slice(array_reverse($handicap_rounds), 0, 20);
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
