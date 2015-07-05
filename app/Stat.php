<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Season;
use App\Player;

class Stat extends Model {

    public $timestamps = false;

    protected $guarded = [];

    public function player() {
        return $this->belongsTo('App\Player');
    }

    public function table() {
        $season = Season::current();
        $players = Player::all();
        $stats = Stat::where('season_id', $season->id)->orderBy('label', 'DESC')->get();

        foreach($players as $player) {
            foreach($stats as $stat) {
                if($stat->label == 'position' && $stat->player_id == $player->id) {
                    $position = json_decode($stat->json);
                    $table[$position->total]['details'] = $player;
                    $key[$player->id] = $position->total;
                }elseif($stat->label == 'points' && $stat->player_id == $player->id) {
                    $points = json_decode($stat->json);
                    $table[$key[$player->id]]['points'] = $points->total;
                }
            }
        }
        ksort($table);
        return $table;
    }
}
