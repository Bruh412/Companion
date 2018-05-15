<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public $table = 'equipments';
    protected $primaryKey = 'equipmentID';
    public $incrementing = false;
    public $timestamps = false;
}
