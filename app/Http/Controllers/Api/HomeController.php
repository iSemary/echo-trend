<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;

class HomeController extends ApiController {
    public function index(): JsonResponse {
        return $this->return(200, "Home");
    }
}
