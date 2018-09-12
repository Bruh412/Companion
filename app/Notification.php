<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $table = 'notifications';
    protected $primaryKey = 'id';
    // public $incrementing = false;
    public $timestamps = true;

}
