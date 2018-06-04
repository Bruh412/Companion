<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchPostQuote extends Model
{
    public $table = 'matchpostquote';
    protected $primaryKey = 'matchID';
    public $timestamps = false;
    public $incrementing = false;

    public function post(){
        return $this->hasOne("App\PostStatus", "post_id", "post_id");
    }
    
    public function quote(){
        return $this->hasOne("App\Quote", "quoteID", "quoteID");
    }
}
