<?php

namespace modules\Article\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'reference_url',
        'body',
        'image',
        'provider_id',
        'source_id',
        'category_id',
        'author_id',
        'language_id',
        'published_at',
    ];
}
