<?php

namespace modules\Provider\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Services\ScrapNews;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use modules\Provider\Entities\Provider;
use modules\Provider\Http\Requests\CreateProviderRequest;

class ProviderController extends ApiController {
    /**
     * The function sync() calls the run() method of the ScrapNews class to fetch all the news from the service providers.
     */
    public function sync() {
        return (new ScrapNews)->run();
    }

    /**
     * The function registers a new provider by encrypting the API key and creating a new record in the
     * Provider table.
     * 
     * @param CreateProviderRequest createProviderRequest An instance of the CreateProviderRequest class,
     * which is a request object containing the data needed to create a new provider.
     * 
     * @return JsonResponse A JsonResponse object is being returned.
     */
    public function register(CreateProviderRequest $createProviderRequest): JsonResponse {
        $requestData = $createProviderRequest->validated();
        // Encrypt the api key in the database
        $requestData['api_key'] = Crypt::encrypt($requestData['api_key']);
        // Create new provider
        Provider::create($requestData);
        return $this->return(200, "Provider Registered Successfully");
    }
}
