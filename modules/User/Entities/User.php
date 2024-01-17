<?php

namespace modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone',
        'username',
        'country_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userInterests() {
        return $this->hasMany(UserInterest::class, 'user_id');
    }

    /**
     * The function syncInterests syncs the given interests with the user's interests for a specific type.
     * 
     * @param array interests An array of interests that need to be synced for a user.
     * @param int typeId The `typeId` parameter represents the type of interest. It is used to identify the
     * type of item for which the interests are being synced.
     */
    public function syncInterests(array $interests, int $typeId) {
        if (isset($interests) && is_array($interests) && count($interests)) {
            UserInterest::whereUserId($this->attributes['id'])->whereItemTypeId($typeId)->delete();
            foreach ($interests as $interest) {
                UserInterest::withTrashed()->whereUserId($this->attributes['id'])
                    ->updateOrCreate(
                        ['user_id' => $this->attributes['id'], 'item_type_id' => $typeId, 'item_id' => $interest],
                        ['deleted_at' => null]
                    );
            }
        }
    }

    /**
     * The function `recordUserViewItem` records a user's view of an item with the specified user ID, item
     * ID, and item type ID.
     * 
     * @param int userId The user ID is an integer that represents the unique identifier of the user who
     * viewed the item. It is used to associate the view record with a specific user.
     * @param int itemId The `itemId` parameter represents the ID of the item that the user viewed.
     * @param int itemTypeId The `itemTypeId` parameter represents the type of the item being viewed. It is
     * an integer value that identifies the category or type of the item.
     */
    public static function recordUserViewItem(int $userId, int $itemId, int $itemTypeId): void {
        UserView::updateOrCreate([
            'user_id' => $userId,
            'item_id' => $itemId,
            'item_type_id' => $itemTypeId,
        ]);
    }
}
