<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateFile extends Model
{
    protected $table = "certificatefiles";
    protected $primaryKey = "fileID";
    public $timestamps = false;
    public $incrementing = false;
}
