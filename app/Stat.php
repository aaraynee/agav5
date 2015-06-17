<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model {

    public $timestamps = false;
    
    protected $fillable = ['label', 'player_id', 'season_id', 'json'];
    
    public function player() {
        return $this->belongsTo('App\Player');
    }  
    

    public function rankings() {
        
        return "Hello";
        
    }        
}