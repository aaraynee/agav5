<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

    public $timestamps = false;

    protected $guarded = [];

    public function tournament() {
        return $this->hasOne('App\Tournament');
    }

    public function getScorecardArrayAttribute() {
        $holes = explode("|", $this->attributes['scorecard']);
        if(count($holes) == 9) {
            $holes = explode("|", $this->attributes['scorecard'] . '|' . $this->attributes['scorecard']);
        }
        $i = 1;
        foreach($holes as $hole) {
            $hole_details = explode(" ", $hole);

            if($this->attributes['unit'] == 1) {
                $hole_details[0] *= 0.9144;
            }

            $scorecard['distance'][$i] = floor($hole_details[0]);
            $scorecard['par'][$i] = $hole_details[1];

            $i++;
        }
      return $scorecard;
    }

    public function getAgaRatingAttribute() {
        return round((40/$this->attributes['course_layout']) + (40/$this->attributes['course_conditions']) + (5/$this->attributes['clubhouse']) + (15/$this->attributes['green_fees']),  1);
    }

}
