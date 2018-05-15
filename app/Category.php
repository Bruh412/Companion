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
        return $this->hasMany("companion\Keyword", "categoryID", "categoryID");
    }
}
