<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use modules\Provider\Entities\Provider;

class ScrapNews {

    public function run() {
        $providers = Provider::get();
    }
}
