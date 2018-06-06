<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueTalkCircle extends Model
{
    public $table = 'queueTalkCircle';
    protected $primaryKey = 'queueID';
    public $incrementing = false;
    public $timestamps = false;

    public function problems(){
        return $this->hasMany('App\QueueUsersProblem', 'queueID', 'queueID');
    }   

    public function user(){
        return $this->hasOne('App\SystemUser', 'user_id', 'user_id');
    }
}
