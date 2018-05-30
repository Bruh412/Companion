<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueUsersProblem extends Model
{
    public $table = "queueusersproblems";
    protected $primaryKey = 'id';
    public $timestamps = false;
    // public $incrementing = false;
    
    public function queueUser(){
        return $this->hasOne('App\QueueTalkCircle','queueID','queueID');
    }

    public function problem(){
        return $this->hasOne('App\Problem', 'problem_id', 'problem_id');
    }
}
