<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryImage extends Model
{
    public $table = 'categoryimage';
    protected $primaryKey = 'catImageID';
    public $incrementing = false;
    public $timestamps = false;
}
