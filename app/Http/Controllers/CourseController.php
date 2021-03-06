<?php 

namespace App\Http\Controllers;

use App\Course;

class CourseController extends Controller {

	public function __construct() {
	}

	public function all() {
        $data['courses'] = Course::orderBy('course_rating', 'desc')->get();
		return view('course/all', $data);
	}
    
    public function single($slug) {
        $data['course'] = Course::where('slug', $slug)->first();        
		return view('course/single', $data);
	}
}