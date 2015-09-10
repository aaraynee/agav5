<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Course;

class Courses extends Command {

    protected $name = 'courses';

    protected $description = 'Command description.';

    public function __construct()
    {
        parent::__construct();
    }


    public function fire()
    {
        $courses = Course::all();
        foreach($courses as $course) {
            $this->info("--------------------");
            $this->info($course->name);
            $this->info("--------------------");

            $rating = round((35/$course->course_layout) + (35/$course->course_conditions) + (15/$course->green_fees) + (5/$course->clubhouse) + (10/$course->golfers), 1);

            $course->course_rating = $rating;
            $course->save();
        }

    }
}
