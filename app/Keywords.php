<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keywords extends Model
{
    public $table = 'keywords';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
}
