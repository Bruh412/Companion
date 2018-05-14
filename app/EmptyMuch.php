<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmptyMuch extends Model
{
    public $table = 'emptymuch';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
