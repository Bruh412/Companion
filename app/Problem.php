<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $table = 'problem';
    protected $primaryKey = 'problem_id';
    public $incrementing = false;
    public $timestamps = false;
}
