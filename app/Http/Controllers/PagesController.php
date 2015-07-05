<?php namespace App\Http\Controllers;

use App\Stat;

class PagesController extends Controller {

	public function index()
	{
		return view('home');
	}

	public function rankings()
	{
        $data['standings'] = Stat::first();        
		return view('pages/rankings', $data);
	}


}
