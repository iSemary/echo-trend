<?php

namespace modules\User\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use modules\User\Entities\User;
use modules\User\Http\Requests\ProfileRequest;

class UserController extends ApiController {
    public function getProfile(): JsonResponse {
        $user = auth()->guard('api')->user();
        return $this->return(200);
    }
    
    public function updateProfile(ProfileRequest $profileRequest): JsonResponse {
        $user = auth()->guard('api')->user();

        return $this->return(200);
    }
}
