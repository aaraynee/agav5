<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Matchup extends Model {

    public $timestamps = false;

    protected $guarded = [];

    public function rounds() {
        return $this->hasMany('App\Round');
    }

    public function player1() {
        return $this->hasOne('App\Player', 'id', 'player_1');
    }

    public function player2() {
        return $this->hasOne('App\Player', 'id', 'player_2');
    }

}