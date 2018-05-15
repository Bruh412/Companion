<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    public $table = 'steps';
    protected $primaryKey = 'stepID';
    public $incrementing = false;
    public $timestamps = false;
}
