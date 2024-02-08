<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PAEQuestions extends Model
{
    public $table = 'paequestions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // public $incrementing = false;
}
