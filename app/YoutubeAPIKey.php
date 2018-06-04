<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoutubeAPIKey extends Model
{
    public $api_key = 'AIzaSyDHkJqCRBtWf4haAvhR-AsbTvhNefCEdSk';
    public $table = "youtubevideo";
    protected $primaryKey = "videoID";
    public $incrementing = false;

    public function matchVideo(){
        return $this->hasMany("App\MatchVideo", "videoID", "videoID");
    }
}
