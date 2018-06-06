<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilitatorSpec extends Model
{
    public $table = 'facilitatorspecs';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // public $incrementing = false;

    protected $fillable = [
        'user_id', 'spec_id', 
    ];

    public function spec(){
        return $this->hasOne('App\Specialization', 'spec_id', 'spec_id');
    }
}
