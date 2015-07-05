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

        $labels = ['points', 'position', 'last', 'top2', 'wins', 'played'];

        foreach($this->stats as $stat) {
            if($stat->label == 'points') {
                $array = json_decode($stat->json);
                $stats[$stat->player_id][$stat->label] = $array->total;
            } elseif($stat->label == 'position') {
                $array = json_decode($stat->json);
                $stats[$stat->player_id][$stat->label] = $array->total;$position_array[$stat->player_id] = $array->total;
                $stats[$stat->player_id]['last'] = $array->last;
            } elseif($stat->label != 'last') {
                $stats[$stat->player_id][$stat->label] = $stat->json;
            }
        }

        asort($position_array);

        $players = Player::all();
        $i = 0;
        foreach($position_array as $player_id => $position) {
            foreach($players as $player) {
                if($player_id == $player->id) {
                    $table_order[$i]['details'] = $player;
                    $table_order[$i]['stats'] = $stats[$player->id];
                    $change = $stats[$player->id]['last'] - $stats[$player->id]['position'];

                    if($change > 0) {
                        $change = abs($change);
                        $change = "<i class='uk-icon-chevron-up uk-icon-justify' style='color:green'></i> $change";
                    } elseif($change < 0) {
                        $change = abs($change);
                        $change = "<i class='uk-icon-chevron-down uk-icon-justify' style='color:red'></i> $change";
                    } else {
                        $change = "<i class='uk-icon-minus uk-icon-justify'></i>";
                    }


                    $table_order[$i]['stats']['change'] = $change;
                    $i++;
                }
            }
        }

        return $table_order;
    }
}
