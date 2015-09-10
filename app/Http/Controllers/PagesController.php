<?php namespace App\Http\Controllers;

use App\Stat;
use App\Post;
use App\Tournament;

class PagesController extends Controller {

	public function index()
	{
		$data['latest_news'] = Post::orderBy('date', 'desc')->limit(6)->get();

		$data['upcoming'] = Tournament::where('date', '>', date('Y-m-d'))->orderBy('date', 'asc')->first();
		$data['tournament'] = Tournament::where('date', '<', date('Y-m-d'))->orderBy('date', 'desc')->first();

		$data['rankings'] = array_slice(Stat::first()->table(), 0, 3);

		return view('home', $data);
	}

	public function rankings()
	{
        $data['standings'] = Stat::first();        
		return view('pages/rankings', $data);
	}


}
