<?php

namespace modules\Provider\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use modules\Provider\Entities\Provider;

class ProviderSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Provider::updateOrCreate(
            [
                'name' => 'NewsAPI',
                'class_name' => '\App\Services\Providers\NewsAPI',
                'end_point' => 'https://newsapi.org/v2/',
                'api_key' => Crypt::encrypt('d607acc451434c33baca2a38052085dd'),
            ],
            [
                'name' => 'NewsDataIO',
                'class_name' => '\App\Services\Providers\NewsDataIO',
                'end_point' => 'https://newsdata.io/api/1/',
                'api_key' => Crypt::encrypt('pub_36573cad0b36ac8ea5697807f39d82ca96f51'),
            ],
            [
                'name' => 'NewsAPIAi',
                'class_name' => '\App\Services\Providers\NewsAPIAi',
                'end_point' => 'http://eventregistry.org/api/v1/',
                'api_key' => Crypt::encrypt('934b9bbc-4908-4123-83ae-561eb197221e'),
            ]
        );
    }
}
