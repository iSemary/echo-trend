<?php

namespace modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInterest extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'item_id', 'item_type_id', 'deleted_at'];


    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
