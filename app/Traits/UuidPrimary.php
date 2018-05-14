<?php


namespace App\Traits;
use Webpatser\Uuid\Uuid;


trait UuidPrimary
{
   
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Uuid::generate()->string;
        });
    }
}