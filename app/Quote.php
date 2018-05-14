<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    public $table = 'quotes';
    protected $primaryKey = 'quoteID';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'quoteID','quoteText','quoteAuthor',
    ];
}
