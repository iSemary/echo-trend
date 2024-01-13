<?php

namespace modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use modules\Article\Entities\Article;

class Category extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'slug', 'parent_id', 'order_number', 'status'];

    public function articles() {
        return $this->hasMany(Article::class);
    }
}
