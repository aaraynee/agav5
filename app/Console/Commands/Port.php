<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use DB;

use App\Stat;
use App\Round;
use App\Course;
use App\Player;
use App\Tournament;

class Port extends Command {

	protected $name = 'port';

	protected $description = 'Port from wordpress';

	public function __construct()
	{
		parent::__construct();
	}

    public function fire()
	{
        $this->courses();
        $this->tournaments();
        $this->players();
        $this->rounds();
    }

    public function courses()
	{
        $ids = [];
        $attributes = ['scorecard', 'address', 'longitude','latitude','scratch_rating','slope_rating','unit'];
        $posts = DB::table('wp_posts')->where('post_type', 'course')->whereIn('post_status', ['publish', 'future'])->get();
        foreach($posts as $post) {
            $course = Course::firstOrNew(['slug' => $post->post_name]);
            $course->id = $post->ID;
            $course->name = $post->post_title;
            $course->save();

            $this->comment('------------');
            $this->info("{$post->post_title} DONE");
            $this->comment('------------');

            $ids[] = $post->ID;

            foreach($attributes as $attribute) {
                $meta_data[$post->ID][$attribute] = NULL;
            }
        }

        $post_meta = DB::table('wp_postmeta')->whereIn('post_id', $ids)->get();
        foreach($post_meta as $meta) {
            $meta_data[$meta->post_id][$meta->meta_key] = $meta->meta_value;
        }

        foreach($ids as $id) {
            $location = explode("\"", $meta_data[$id]['location']);
            $course = Course::find($id);
            $course->scorecard = $meta_data[$id]['scorecard'];
            $course->address = $location[3];
            $course->latitude = $location[7];
            $course->longitude = $location[11];
            $course->scratch_rating = $meta_data[$id]['scratch_rating'];
            $course->slope_rating = $meta_data[$id]['slope_rating'];
            $course->unit = (($meta_data[$id]['unit'] == 'yards') ? 1 : 0);
            $course->save();
        }
	}

    public function tournaments()
	{
        $ids = [];
        $attributes = ['course', 'scoring', 'type','points','date','completed'];
        $posts = DB::table('wp_posts')->where('post_type', 'tournament')->whereIn('post_status', ['publish', 'future'])->get();
        foreach($posts as $post) {
            $tournament = Tournament::firstOrNew(['slug' => $post->post_name]);
            $tournament->id = $post->ID;
            $tournament->name = $post->post_title;
            $tournament->date = $post->post_date;
            $tournament->save();

            $this->comment('------------');
            $this->info("{$post->post_title} DONE");
            $this->comment('------------');

            $ids[] = $post->ID;

            foreach($attributes as $attribute) {
                $meta_data[$post->ID][$attribute] = NULL;
            }
        }

        $post_meta = DB::table('wp_postmeta')->whereIn('post_id', $ids)->get();
        foreach($post_meta as $meta) {
            $meta_data[$meta->post_id][$meta->meta_key] = $meta->meta_value;
        }

        foreach($ids as $id) {

            $term_relationship = DB::table('wp_term_relationships')->where('object_id', $id)->first();
            $term = DB::table('wp_terms')->where('term_id', $term_relationship->term_taxonomy_id)->first();



            $course_info = explode("\"",$meta_data[$id]['course']);
            $tournament = Tournament::find($id);
            $tournament->points = $meta_data[$id]['points'];
            $tournament->course_id = $course_info[1];
            $tournament->scoring = $meta_data[$id]['type'];
            $tournament->type = $term->slug;
            $tournament->save();
        }
	}

	public function players()
	{
        $ids = [];
        $attributes = ['country', 'height', 'weight','clubs','debut','glove','dob', 'pob', 'college'];
        $posts = DB::table('wp_posts')->where('post_type', 'player')->whereIn('post_status', ['publish', 'future'])->get();
        foreach($posts as $post) {
            $player = Player::firstOrNew(['slug' => $post->post_name]);
            $name = explode(" ", $post->post_title);
            $player->id = $post->ID;
            $player->firstname = $name[0];
            $player->lastname = $name[1];
            $player->bio = $post->post_content;
            $player->save();

            $this->comment('------------');
            $this->info("{$post->post_title} DONE");
            $this->comment('------------');

            $ids[] = $post->ID;

            foreach($attributes as $attribute) {
                $meta_data[$post->ID][$attribute] = NULL;
            }
        }

        $post_meta = DB::table('wp_postmeta')->whereIn('post_id', $ids)->get();
        foreach($post_meta as $meta) {
            $meta_data[$meta->post_id][$meta->meta_key] = $meta->meta_value;
        }

        foreach($ids as $id) {
            $player = Player::find($id);
            $player->country = $meta_data[$id]['country'];
            $player->height = $meta_data[$id]['height'];
            $player->weight = $meta_data[$id]['weight'];
            $player->clubs = $meta_data[$id]['clubs'];
            $player->debut = $meta_data[$id]['debut'];
            $player->glove = $meta_data[$id]['glove'];
            $player->dob = $meta_data[$id]['dob'];
            $player->pob = $meta_data[$id]['pob'];
            $player->college = $meta_data[$id]['college'];
            $player->save();
        }
	}

    public function rounds()
	{
        $ids = [];
        $attributes = ['player', 'tournament', 'adjusted', 'position', 'points', 'differential', 'official', 'strokes', 'total'];
        $posts = DB::table('wp_posts')->where('post_type', 'round')->whereIn('post_status', ['publish', 'future'])->get();
        foreach($posts as $post) {
            $round = Round::firstOrNew(['id' => $post->ID]);
            $round->save();

            $this->comment('------------');
            $this->info("{$post->ID} DONE");
            $this->comment('------------');

            $ids[] = $post->ID;

            foreach($attributes as $attribute) {
                $meta_data[$post->ID][$attribute] = NULL;
            }
        }

        $post_meta = DB::table('wp_postmeta')->whereIn('post_id', $ids)->get();
        foreach($post_meta as $meta) {
            $meta_data[$meta->post_id][$meta->meta_key] = $meta->meta_value;
        }

        foreach($ids as $id) {
            $player_info = explode("\"", $meta_data[$id]['player']);
            $tournament_info = explode("\"", $meta_data[$id]['tournament']);
            $round = Round::find($id);
            $round->scorecard = $meta_data[$id]['scorecard'];
            $round->player_id = $player_info[1];
            $round->tournament_id = $tournament_info[1];

            $round->total = $meta_data[$id]['total'];
            $round->strokes = $meta_data[$id]['strokes'];
            $round->adjusted = $meta_data[$id]['official'];
            $round->handicap = $meta_data[$id]['differential'];
            $round->points = $meta_data[$id]['points'];
            $round->position = $meta_data[$id]['position'];



            $round->save();
        }
    }
}
