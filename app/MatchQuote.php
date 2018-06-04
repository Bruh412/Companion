<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchQuote extends Model
{
    public $table = 'matchquote';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // public $incrementing = false;

    protected $fillable = [
        'categoryID', 'quoteID', 
    ];

    public function quotes(){
        return $this->hasOne('App\Quote','quoteID','quoteID');
    }

    public function categories(){
        return $this->hasOne('App\Category','categoryID','categoryID');
    }

    public function post(){
        return $this->hasOne('App\PostStatus','post_id','post_id');
    }
}
