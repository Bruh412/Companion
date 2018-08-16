<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $table = "groupmembers";
    protected $primaryKey = "groupMemberID";
    public $timestamps = false;
    public $incrementing = false;

    // public function group(){
    //     return $this->belongsTo("App\Group", "groupID", "groupID");
    // }
}
