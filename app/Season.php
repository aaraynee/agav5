<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model {

    public $timestamps = false;
    
    public function tournaments() {
        return $this->hasMany('App\Tournament')->orderBy('date', 'asc');
    }
    
    public function scopeCurrent($query) {
        $year = date('Y');
        return $query->where('year', $year)->first();      
    }
}