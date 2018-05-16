<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    public $table = 'specialization';
    protected $primaryKey = 'spec_id';
    public $incrementing = false;
    public $timestamps = false;
}
