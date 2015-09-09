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
}
