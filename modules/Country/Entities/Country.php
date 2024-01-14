<?php

namespace modules\Country\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'code'];


    public static function getCountryIdByCode(string $countryCode): int {
        $country = self::select('id')->whereCode($countryCode)->first();
        if (!$country) {
            $country = self::create([
                'name' => $countryCode,
                'code' => $countryCode,
            ]);
        }
        return $country->id;
    }
}
