<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupActivities extends Model
{
    protected $table = "groupactivities";
    protected $primaryKey = "groupActID";
    public $timestamps = false;
    public $incrementing = true;

    public function group(){
        return $this->belongsTo("App\Group", "groupID", "groupID");
    }
}
