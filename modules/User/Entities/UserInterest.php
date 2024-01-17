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

    /**
     * The function `getItemIds` retrieves an array of item IDs based on a given user ID and item type ID.
     * 
     * @param int userId The userId parameter is an integer that represents the ID of the user for whom we
     * want to retrieve the item IDs.
     * @param int itemTypeId The itemTypeId parameter is an integer that represents the type of item you
     * want to retrieve. It is used to filter the items based on their type.
     * 
     * @return array an array of item IDs.
     */
    public static function getItemIds(int $userId, int $itemTypeId): array {
        return self::where('user_id', $userId)
            ->where('item_type_id', $itemTypeId)
            ->pluck("item_id")
            ->toArray();
    }
}
