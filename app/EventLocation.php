<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventLocation extends Model
{
    public $table = 'event_location';
    protected $primaryKey = 'eventLoc_id';
    public $incrementing = false;
    public $timestamps = false;
}
