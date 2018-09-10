<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventLocation extends Model
{
    protected $table = "eventLocation";
    protected $primaryKey = "id";
    public $timestamps = false;
    public $incrementing = true;
}
