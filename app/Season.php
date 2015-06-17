<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Player;

class Season extends Model {

    public $timestamps = false;
        
    public function tournaments() {
        return $this->hasMany('App\Tournament')->orderBy('date', 'asc');
    }
    
    public function stats() {
        return $this->hasMany('App\Stat');
    }    
    
    public function scopeCurrent($query) {
        $year = date('Y');
        return $query->where('year', $year)->first();      
    }
    
    public function players() {
        $stats = array();
        $table_order = array();
        foreach($this->stats as $stat) {
            if($stat->label == 'points') {
                $array = json_decode($stat->json);
                $stats[$stat->player_id]['points'] = $array['total']; 
            }
            if($stat->label == 'position') {
                $array = json_decode($stat->json);
                $position_array[$stats->player_id] = $stats[$stats->player_id]['position'] = $array['total']; 
                $stats[$stat->player_id]['last'] = $array['total']; 
            }
            if($stat->label == 'top2') {
                $stats[$stat->player_id]['top2'] = $stat->json; 
            }
            if($stat->label == 'wins') {
                $stats[$stat->player_id]['wins'] = $stat->json; 
            }     
            if($stat->label == 'played') {
                $stats[$stat->player_id]['played'] = $stat->json; 
            }        
        }
        
        asort($position_array);
        
        $players = Player::all();
        $i = 0;
        foreach($position_array as $player_id => $position) {
            foreach($players as $player) {
                if($player_id == $player->id) {
                    $table_order[$i]['player'] = $player;
                    $table_order[$i]['stats'] = $position;

                    $i++;    
                }
            }
        }        
        
        return $table_order;
    }
}