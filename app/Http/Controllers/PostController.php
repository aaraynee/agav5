<?php

namespace App\Http\Controllers;

use App\Post;

class PostController extends Controller {

	public function __construct() {
	}

	public function blog() {
		$data['posts'] = Post::orderBy('date', 'desc')->paginate(5);
		return view('post/all', $data);
	}

	public function single($slug) {
		$data['post'] = Post::where('slug', $slug)->first();
		return view('post/single', $data);
	}
}