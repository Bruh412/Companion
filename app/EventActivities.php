<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventActivities extends Model
{
    protected $table = "eventActivities";
    protected $primaryKey = "id";
    public $timestamps = false;
    public $incrementing = true;
}
