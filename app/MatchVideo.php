<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchVideo extends Model
{
    public $table = "matchvideo";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function categories(){
        return $this->hasOne("App\Category", "categoryID", "categoryID");
    }

    public function videos(){
        return $this->hasOne("App\YoutubeAPIKey", "videoID", "videoID");
    }
}
