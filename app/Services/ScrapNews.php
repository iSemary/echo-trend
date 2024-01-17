<?php

namespace App\Services;

use App\Interfaces\ProviderInterface;
use modules\Provider\Entities\Provider;

class ScrapNews {
    /**
     * The function iterates through a list of providers, checks if the provider's name is in a predefined
     * list of providers, dynamically creates an instance of the provider's class, and calls the fetch
     * method if it exists.
     */
    public function run(): void {
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
                // Set the provider last fetched at
                $provider->update(['fetched_at' => now()]);
            }
        }
    }
}
