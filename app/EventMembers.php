<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMembers extends Model
{
    protected $table = "eventMembers";
    protected $primaryKey = "id";
    public $timestamps = false;
    public $incrementing = true;
}
