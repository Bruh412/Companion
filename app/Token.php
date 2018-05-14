<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Token extends Model
{
    use Uuids;

    public $table = 'tokens';
    protected $primaryKey = 'token_id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'token',
    ];
}
