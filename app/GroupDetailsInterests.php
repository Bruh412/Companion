<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupDetailsInterests extends Model
{
    protected $table = "groupdetailsinterests";
    protected $primaryKey = "groupDetailID";
    public $timestamps = false;
    public $incrementing = false;

    public function group(){
        return $this->belongsTo("App\Group", "groupID", "groupID");
    }
}
