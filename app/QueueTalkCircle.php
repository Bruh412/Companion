<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueTalkCircle extends Model
{
    public $table = 'queueTalkCircle';
    protected $primaryKey = 'queueID';
    public $incrementing = false;
    public $timestamps = false;
}
