<?php 

namespace App\Http\Controllers;

use App\Season;

class SeasonController extends Controller {

	public function __construct() {
	}

	public function all() {
        $data['seasons'] = Season::all();
		return view('season/all', $data);
	}
    
    public function single($slug) {
        $data['season'] = Season::where('slug', $slug)->first();        
		return view('season/single', $data);
	}
}