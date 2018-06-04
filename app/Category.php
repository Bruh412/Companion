<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categories';
    protected $primaryKey = 'categoryID';
    public $incrementing = false;
    public $timestamps = false;

    public function keywords(){
        return $this->hasMany("App\Keyword", "categoryID", "categoryID");
    }

    public function matchQuote(){
        return $this->hasMany("App\MatchQuote", "categoryID", "categoryID");
    }

    public function matchVideo(){
        return $this->hasMany("App\MatchVideo", "categoryID", "categoryID");
    }
}
