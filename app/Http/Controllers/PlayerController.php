<?php

namespace App\Http\Controllers;

use App\Player;
use App\Season;

class PlayerController extends Controller {

	public function __construct() {
	}

	public function all() {
        $data['players'] = Player::orderBy('firstname', 'ASC')->get();
		return view('player/all', $data);
	}

    public function single($slug) {
        $data['current_season'] = Season::orderBy('year', 'DESC')->first();
        $data['seasons'] = Season::orderBy('year', 'DESC')->get();
        $data['player'] = Player::where('slug', $slug)->first();

        $made = ['eagles','birdies','pars','bogeys','double bogeys','triple bogeys'];
        $distance = [
            '150' => array(3),
            '200' => array(3),
            '250' => array(4),
            '350' => array(4,5),
            '400' => array(4,5),
            '450' => array(4,5),
            '500' => array(5),
            '575' => array(5)
        ];

        $data['stats'] = ['distance' => $distance, 'made' => $made];
		return view('player/single', $data);
	}
}
