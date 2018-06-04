<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = "files";
    protected $primaryKey = "fileID";
    public $timestamps = false;
    public $incrementing = false;

    public function activity(){
        return $this->belongsTo("App\Activity", "actID", "actID");
    }
}
