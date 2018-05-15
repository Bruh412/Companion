<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = "activities";
    protected $primaryKey = "actID";
    public $timestamps = false;
    public $incrementing = false;

    public function activityTags(){
        return $this->hasMany("companion\ActivityTag", "actID", "actID");
    }

    public function media(){
        return $this->hasMany("companion\Files", "actID", "actID");
    }

    public function steps(){
        return $this->hasMany("companion\Step", "actID", "actID");
    }

    public function equipments(){
        return $this->hasMany("companion\Equipment", "actID", "actID");
    }

    public function testing(){
        return "hi!";
    }
}
