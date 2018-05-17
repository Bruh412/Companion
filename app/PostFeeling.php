<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostFeeling extends Model
{
    public $table = 'postfeelings';
    protected $primaryKey = 'post_feeling_id';
    public $incrementing = false;
    public $timestamps = false;

    public function usersPostFeeling(){
        return $this->hasOne('App\UsersPostFeeling','post_feeling_id','post_feeling_id');
    }
}
