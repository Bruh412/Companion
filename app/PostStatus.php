<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostStatus extends Model
{
    public $table = 'poststatus';
    protected $primaryKey = 'post_id';
    public $timestamps = false;
    public $incrementing = false;

    public function usersPostFeeling(){
        return $this->hasOne('App\UsersPostFeeling','post_id','post_id');
    }

    public function user(){
        return $this->hasOne('App\SystemUser','post_user_id','user_id');
    }
}
