<?php

namespace modules\Provider\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Services\ScrapNews;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use modules\Provider\Entities\Provider;
use modules\Provider\Http\Requests\CreateProviderRequest;

class ProviderController extends ApiController {
    public function sync() {
        return (new ScrapNews)->run();
    }

    public function register(CreateProviderRequest $createProviderRequest): JsonResponse {
        $requestData = $createProviderRequest->validated();
        // Encrypt the api key in the database
        $requestData['api_key'] = Crypt::encrypt($requestData['api_key']);
        // Create new provider
        Provider::create($requestData);
        return $this->return(200, "Provider Registered Successfully");
    }
}
