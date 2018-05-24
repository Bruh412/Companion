<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersInterests extends Model
{
    public $table = "usersinterests";
    protected $primaryKey = 'id';
    public $timestamps = false;
    // public $incrementing = false;

    protected $fillable = [
        'user_id', 'interestID',
    ];
    
    public function user(){
        return $this->hasOne('App\SystemUser','user_id','user_id');
    }

    public function interest(){
        return $this->hasOne('App\Interest', 'interestID', 'interestID');
    }
}
