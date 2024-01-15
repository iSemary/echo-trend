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

    public static function recordUserViewItem(int $userId, int $itemId, int $itemTypeId): void {
        UserView::updateOrCreate([
            'user_id' => $userId,
            'item_id' => $itemId,
            'item_type_id' => $itemTypeId,
        ]);
    }
}
