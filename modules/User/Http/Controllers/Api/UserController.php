<?php

namespace modules\User\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use modules\User\Entities\User;
use modules\User\Http\Requests\ProfileRequest;
use modules\User\Interfaces\UserInterestTypes;

class UserController extends ApiController {
    /**
     * The function `getProfile` retrieves the profile data of an authenticated user and returns it as a
     * JSON response.
     * 
     * @return JsonResponse A JsonResponse object is being returned.
     */
    public function getProfile(): JsonResponse {
        $user = $this->getAuthenticatedUser();
        $profile = $this->prepareProfileData($user);
        return $this->return(200, "Profile fetched successfully", ['profile' => $profile]);
    }

    /**
     * The function prepares profile data for a user, including the user object and their interests.
     * 
     * @param User user The user parameter is an instance of the User class.
     * 
     * @return array An array is being returned.
     */
    private function prepareProfileData(User $user): array {
        return [
            'user' => $user,
            'interests' => $this->prepareUserInterests($user)
        ];
    }

    /**
     * The function prepares and formats a user's interests into an array with categories, authors, and
     * sources.
     * 
     * @param User user The "user" parameter is an instance of the User class.
     * 
     * @return array an array called .
     */
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

    /**
     * The function updates the user's profile information and preferences based on the validated data from
     * the profile request.
     * 
     * @param ProfileRequest profileRequest The `ProfileRequest` is a request object that contains the data
     * submitted by the user for updating their profile. It is typically used to validate and sanitize the
     * input data before updating the user's profile.
     * 
     * @return JsonResponse a JsonResponse with a status code of 200 and a message of 'Profile updated
     * successfully'.
     */
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
