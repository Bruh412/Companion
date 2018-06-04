<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentPost extends Model
{
    protected $table = "commentpost";
    protected $primaryKey = "comment_id";
    public $timestamps = false;
    public $incrementing = false;

    public function user(){
        return $this->hasOne('App\SystemUser','user_id','user_id');
    }

    public function post(){
        return $this->hasOne('App\PostStatus','post_id','post_id');
    }
}
