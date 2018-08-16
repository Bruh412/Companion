<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupDetails extends Model
{
    protected $table = "groupdetails";
    protected $primaryKey = "groupDetailID";
    public $timestamps = false;
    public $incrementing = false;

    public function group(){
        return $this->belongsTo("App\Group", "groupID", "groupID");
    }

    public function problem(){
        return $this->hasOne("App\Problem", "problem_id", "problemID");
    }
}
