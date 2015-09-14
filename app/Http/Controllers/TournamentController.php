<?php 

namespace App\Http\Controllers;

use App\Season;
use App\Tournament;
use App\Player;
use App\Round;

class TournamentController extends Controller {

	public function __construct() {
	}

	public function all() {
        $data['season'] = Season::current();
		return view('tournament/all', $data);
	}

    public function single($slug) {
        $data['tournament'] = Tournament::where('slug', $slug)->first();
		$team = [];
		if($data['tournament']->scoring == 'cup') {
			$players = Player::all();
			foreach($players as $player) {
				$data['team'][$player->id] = $player->team;
			}
		}
		return view('tournament/single', $data);
	}
}
