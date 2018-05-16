<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilitatorPRC extends Model
{
    public $table = 'facilitatorprc';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'prc_id', 
    ];
}
