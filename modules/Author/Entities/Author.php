<?php

namespace modules\Author\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model {
    use HasFactory;

    protected $fillable = ['name', 'slug', 'source_id'];
}
