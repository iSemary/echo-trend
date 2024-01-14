<?php

namespace modules\User\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use modules\User\Entities\User;
use modules\User\Http\Requests\ProfileRequest;
use modules\User\Interfaces\UserInterestTypes;

class UserController extends ApiController {
    public function getProfile(): JsonResponse {
        $user = $this->getAuthenticatedUser();
        $profile = $this->prepareProfileData($user);
        return $this->return(200, "Profile fetched successfully", ['profile' => $profile]);
    }

    private function prepareProfileData(User $user): array {
        return [
            'user' => $user,
            'interests' => $this->prepareUserInterests($user)
        ];
    }

    private function prepareUserInterests(User $user): array {
        $formattedUserInterests = [
            "categories" => [],
            "authors" => [],
            "sources" => [],
        ];

        $userInterests = $user->userInterests()->get();

        foreach ($userInterests as $interest) {
            switch ($interest->item_type_id) {
                case UserInterestTypes::CATEGORY:
                    $formattedUserInterests['categories'][] = $interest->item_id;
                    break;
                case UserInterestTypes::AUTHOR:
                    $formattedUserInterests['authors'][] = $interest->item_id;
                    break;
                case UserInterestTypes::SOURCE:
                    $formattedUserInterests['sources'][] = $interest->item_id;
                    break;
            }
        }

        return $formattedUserInterests;
    }

    public function updateProfile(ProfileRequest $profileRequest): JsonResponse {
        $user = $this->getAuthenticatedUser();
        $validatedData = $profileRequest->validated();
        // Update user info
        $user->update($validatedData);
        // Update user preferences
        $user->syncInterests($validatedData['categories'], UserInterestTypes::CATEGORY);
        $user->syncInterests($validatedData['authors'], UserInterestTypes::AUTHOR);
        $user->syncInterests($validatedData['sources'], UserInterestTypes::SOURCE);
        
        return $this->return(200, 'Profile updated successfully');
    }
}
