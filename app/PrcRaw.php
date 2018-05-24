<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrcRaw extends Model
{
    public $table = 'prcraw';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
