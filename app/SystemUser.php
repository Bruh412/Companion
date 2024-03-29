<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use App\Traits\UuidPrimary;
use App\UsersInterests;

class SystemUser extends Eloquent implements Authenticatable
{
    use UuidPrimary, AuthenticatableTrait;
    
    public $table = 'systemusers';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'birthday','gender', 'password','userType'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function postStatus(){
        return $this->hasMany('App\PostStatus','post_user_id','user_id');
    }

    public function interests(){
        return $this->hasMany('App\UsersInterests','user_id','user_id');
    }

    public function comments(){
        return $this->hasMany('App\CommentPost','user_id','user_id');
    }
}
