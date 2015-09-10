<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

    public $timestamps = false;

    protected $guarded = [];

    public function getExcerptAttribute() {
        $string = substr($this->content,0, strpos($this->content, "</p>")+4);
        $string = str_replace("<p>", "", str_replace("</p>", "", $string));
        return $string;
    }

    public function getLinkAttribute() {
      return "/post/{$this->slug}";
    }
}
