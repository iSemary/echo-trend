<?php

namespace modules\Source\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'slug', 'url', 'country_id', 'language_id'];
}
