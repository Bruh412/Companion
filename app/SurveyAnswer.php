<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    public $table = 'surveyanswers';
    protected $primaryKey = 'id';
    // public $incrementing = false;
    public $timestamps = false;
}
