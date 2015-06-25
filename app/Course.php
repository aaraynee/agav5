<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    
    public $timestamps = false;

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
            $scorecard['distance'][$i] = $hole_details[0];
            $scorecard['par'][$i] = $hole_details[1];
                
            $i++;
        }
      return $scorecard;
    }    

}