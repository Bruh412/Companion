<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDetails extends Model
{
    public $table = 'event_details';
    protected $primaryKey = 'event_detailsID';
    public $incrementing = false;
    public $timestamps = false;
}
