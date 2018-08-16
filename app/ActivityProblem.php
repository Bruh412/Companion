<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityProblem extends Model
{
    protected $table = "activityproblem";
    protected $primaryKey = "id";
    public $timestamps = false;
    public $incrementing = false;

    public function problem(){
        return $this->hasOne("App\Problem", "problem_id", "problem_id");
    }

}
