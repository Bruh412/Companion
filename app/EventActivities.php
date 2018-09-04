<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventActivities extends Model
{
    public $table = 'event_activities';
    protected $primaryKey = 'eventAct_id';
    public $incrementing = false;
    public $timestamps = false;
}
