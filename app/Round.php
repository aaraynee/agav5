<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model {

    public $timestamps = false;
    
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
    
}