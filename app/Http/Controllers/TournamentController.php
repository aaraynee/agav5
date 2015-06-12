<?php 

namespace App\Http\Controllers;

use App\Season;
use App\Tournament;
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
		return view('tournament/single', $data);
	}
}