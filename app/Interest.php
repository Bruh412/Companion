<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    public $table = 'interests';
    protected $primaryKey = 'interestID';
    public $timestamps = false;
    public $incrementing = false;
}
