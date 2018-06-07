<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecMatchProblem extends Model
{
    public $table = 'specmatchprob';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    public $timestamps = false;

    public function problems(){
        return $this->hasMany('App\Problem', 'problem_id', 'problem_id');
    } 

    public function spec(){
        return $this->hasOne('App\Specialization', 'spec_id', 'spec_id');
    }   
}
