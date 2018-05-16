<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersInterests extends Model
{
    public $table = "usersinterests";
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'interestID',
    ];
}
