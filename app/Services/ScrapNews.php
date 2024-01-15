<?php

namespace App\Services;

use App\Interfaces\ProviderInterface;
use modules\Provider\Entities\Provider;

class ScrapNews {
    public function run() {
        $providers = Provider::get();
        foreach ($providers as $provider) {
            if (in_array($provider->name, ProviderInterface::PROVIDERS)) {
                $providerClass = $provider->class_name;
                // For example: App\Services\Providers\NewsAPI;
                if (class_exists($providerClass)) {
                    $providerService = new $providerClass($provider);
                    if (method_exists($providerService, 'fetch')) {
                        $providerService->fetch();
                    }
                }
            }
        }
    }
}
