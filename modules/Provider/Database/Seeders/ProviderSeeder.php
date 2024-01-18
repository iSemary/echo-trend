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
        Provider::insert([
            [
                'name' => 'NewsAPI',
                'class_name' => '\App\Services\Providers\NewsAPI',
                'end_point' => 'https://newsapi.org/v2/',
                'api_key' => Crypt::encrypt('da3c845f1d2948bd9940e70980be5e0d'),
            ],
            [
                'name' => 'NewsDataIO',
                'class_name' => '\App\Services\Providers\NewsDataIO',
                'end_point' => 'https://newsdata.io/api/1/',
                'api_key' => Crypt::encrypt('pub_366969aa8f3cdff5cd6dc1a34f0198abce036'),
            ],
            [
                'name' => 'NewsAPIAi',
                'class_name' => '\App\Services\Providers\NewsAPIAi',
                'end_point' => 'http://eventregistry.org/api/v1/',
                'api_key' => Crypt::encrypt('934b9bbc-4908-4123-83ae-561eb197221e'),
            ]]
        );
    }
}
