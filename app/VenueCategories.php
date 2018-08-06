<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueCategories extends Model
{
    public $table = "venuecategories";
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;
}
