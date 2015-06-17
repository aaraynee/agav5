<?php 

namespace App\Http\Controllers;

use App\Season;
use App\Player;

class SeasonController extends Controller {

	public function __construct() {
	}

	public function all() {
        $data['seasons'] = Season::all();
		return view('season/all', $data);
	}
    
    public function single($slug) {
        $season = Season::where('slug', $slug)->first();
        $data['season'] = $season;                
        $data['players'] = $season->players();
		return view('season/single', $data);
	}
}