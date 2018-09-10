<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDetails extends Model
{
    protected $table = "eventDetails";
    protected $primaryKey = "id";
    public $timestamps = false;
    public $incrementing = true;
}
