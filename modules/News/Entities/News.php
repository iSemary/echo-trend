<?php

namespace modules\News\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use modules\News\Database\factories\NewsFactory;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): NewsFactory
    {
        //return NewsFactory::new();
    }
}
