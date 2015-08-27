<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model {

    public $timestamps = false;

    protected $guarded = [];

    public function season() {
        return $this->belongsTo('App\Season');
    }

    public function course() {
        return $this->belongsTo('App\Course');
    }

    public function rounds() {
        return $this->hasMany('App\Round')->orderBy('position', 'asc');
    }

    public function getShortDateAttribute() {
      return date('d-M', strtotime($this->attributes['date']));
    }

    public function defending_champion() {
        $champs = [];
        foreach($this->rounds as $round) {
            if($round->position == 1) {
                $champs[] = $round->player->name;
                $score = $round->scoreboard;
            }
        }

        if(empty($champs)) {
            $slug_array = explode("-", $this->attributes['slug']);
            $old_tournament = Tournament::where('name', 'LIKE', "%{$slug_array[0]}%")->orderBy('date', 'DESC')->get();

            foreach($old_tournament as $tournament) {
                if($tournament->slug != $this->attributes['slug']) {
                    foreach($tournament->rounds as $round) {
                        if($round->position == 1) {
                            $champs[] = $round->player->name;
                            $score = $round->scoreboard;
                        }
                    }
                    break;
                }
            }
        }

        if(empty($champs)) {
            return NULL;
        }

        $defending_champion = implode(",", $champs);
        return "$defending_champion ($score)";
    }
}
