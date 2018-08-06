<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    public $table = "venue";
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;
}
