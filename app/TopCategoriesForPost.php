<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopCategoriesForPost extends Model
{
    public $table = 'top_categories_for_posts';
    protected $primaryKey = 'top_id';
    public $timestamps = false;
    public $incrementing = false;
}
