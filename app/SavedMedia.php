<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedMedia extends Model
{
    public $table = 'savedmedia';
    protected $primaryKey = 'saved_media_id';
    public $incrementing = false;
}
