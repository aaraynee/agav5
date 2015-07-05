<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model {

    public $timestamps = false;

    protected $guarded = [];
    
    public function season() {
        return $this->belongsTo('App\Season');
    }

    public function course() {
        return $this->belongsTo('App\Course');
    }

    public function rounds() {
        return $this->hasMany('App\Round')->orderBy('position', 'asc');
    }
}
