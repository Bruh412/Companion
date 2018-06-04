<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityTag extends Model
{
    protected $table = "activitytags";
    protected $primaryKey = "tagID";
    public $timestamps = false;
    public $incrementing = false;

    public function activity(){
        return $this->hasOne("App\Activity", "actID", "actID");
    }

    public function interest(){
        return $this->hasOne("App\Interest", "interestID", "tagID");
    }
}
