<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = "groups";
    protected $primaryKey = "groupID";
    public $timestamps = false;
    public $incrementing = false;

    public function activities(){
        return $this->hasMany("App\GroupActivities", "groupID", "groupID");
    }

    public function details(){
        return $this->hasMany("App\GroupDetails", "groupID", "groupID");
    }

    public function members(){
        return $this->hasMany("App\GroupMember", "groupID", "groupID");
    }
}
