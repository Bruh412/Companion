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
        return $this->hasMany("App\ActivityTag", "actID", "actID");
    }

    public function media(){
        return $this->hasMany("App\Files", "actID", "actID");
    }

    public function steps(){
        return $this->hasMany("App\Step", "actID", "actID");
    }

    public function equipments(){
        return $this->hasMany("App\Equipment", "actID", "actID");
    }

    public function problems(){
        return $this->hasMany("App\ActivityProblem", "actID", "actID");
    }
}
