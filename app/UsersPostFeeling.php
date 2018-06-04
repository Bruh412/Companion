<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersPostFeeling extends Model
{
    public $table = "userspostfeelings";
    protected $primaryKey = 'id';
    // public $primarykey = null;
    public $timestamps = false;

    protected $fillable = [
        'post_id', 'post_feeling_id',
    ];
    public function postStatus(){
        return $this->hasOne('App\PostStatus','post_id','post_id');
    }

    public function postFeeling(){
        return $this->hasOne('App\PostFeeling','post_feeling_id','post_feeling_id');
    }
}
