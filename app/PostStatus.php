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
        return $this->hasOne('App\SystemUser','user_id','post_user_id');
    }

    public function comments(){
        return $this->hasMany('App\CommentPost','post_id','post_id');
    }

    public function quotes(){
        return $this->hasMany('App\MatchQuote','post_id','post_id');
    }

    public function postQuote(){
        return $this->hasMany('App\MatchPostQuote','post_id','post_id');
    }
}
