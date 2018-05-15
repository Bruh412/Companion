<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keywords extends Model
{
    public $table = 'keywords';
    protected $primaryKey = 'keywordID';
    public $incrementing = false;
    public $timestamps = false;
}
