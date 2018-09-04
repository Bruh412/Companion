<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMembers extends Model
{
    public $table = 'event_members';
    protected $primaryKey = 'event_memberID';
    public $incrementing = false;
    public $timestamps = false;
}
