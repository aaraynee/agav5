<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model {

    public $timestamps = false;
    
    public function player() {
        return $this->belongsTo('App\Player');
    }    
}