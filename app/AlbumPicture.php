<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlbumPicture extends Model
{
    protected $table = "albumpicture";
    protected $primaryKey = "id";
    public $timestamps = false;
    public $incrementing = true;
}
