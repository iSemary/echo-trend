<?php

namespace modules\User\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use modules\User\Http\Requests\LoginRequest;
use modules\User\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use modules\Country\Entities\Country;
use modules\User\Entities\User;
use modules\User\Interfaces\UserInterestTypes;

class AuthController extends ApiController {
    /**
     * Handle user registration.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $registerRequest): JsonResponse {
        /* Requested data passed the validation */
        $userRequest = $registerRequest->validated();
        $email = $userRequest['email'];
        $username = strtok($email, '@');
        // Adding username to the $userRequest array
        $userRequest['username'] = $username .  Str::random(4);
        // Create or update the country code if not exists
        $userRequest['country_id'] = Country::getCountryIdByCode($userRequest['country_code']);
        // Create new user record
        $user = User::create($userRequest);
        // Create user preferred categories
        $user->syncInterests($userRequest['categories'], UserInterestTypes::CATEGORY);
        // Collect user details for authentication
        $response = $this->collectUserDetails($user);
        // Return Success Json Response
        return $this->return(200, 'User Registered Successfully', ['user' => $response]);
    }

    /**
     * Handle user login.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $loginRequest): JsonResponse {
        // Check login credentials
        if (auth()->attempt(['email' => $loginRequest->email, 'password' => $loginRequest->password])) {
            $user = auth()->user();
            // collect user details to return in the json response
            $response = $this->collectUserDetails($user);
            // Return Success Json Response
            return $this->return(200, 'User Logged in Successfully', ['user' => $response]);
        }
        return $this->return(400, 'Invalid email or password');
    }

    /**
     * Collect user details for response.
     *
     * @param User $user
     * @param bool $generateToken
     * @return User
     */
    public function collectUserDetails(User $user, bool $generateToken = true): User {
        if ($generateToken) {
            $accessToken = $this->generateAccessToken($user);
        }
        $userData = $this->selectUserData($user);
        if ($generateToken) {
            $userData['access_token'] = $accessToken;
        }
        return $userData;
    }

    /**
     * Generate an access token for the user.
     *
     * @param User $user
     * @return string
     */
    private function generateAccessToken(User $user): string {
        return $user->createToken('web-app')->accessToken;
    }

    /**
     * The function selects specific user data (full name, email, username, and creation date) based on the
     * user's ID.
     * 
     * @param User user The parameter `` is an instance of the `User` class.
     * 
     * @return User a User object with the selected fields: 'full_name', 'email', 'username', and
     * 'created_at'.
     */
    private function selectUserData(User $user): User {
        return $user->where("id", $user->id)->select('full_name', 'email', 'username', 'created_at')->first();
    }

    /**
     * The function logs out a user by deleting their access tokens either for a specific request or for
     * all tokens associated with the user.
     * 
     * @param Request request The  parameter is an instance of the Request class, which represents
     * an HTTP request. It contains information about the request such as the request method, headers, and
     * input data. In this case, it is used to determine the type of logout action to perform.
     * 
     * @return JsonResponse a JsonResponse.
     */
    public function logout(Request $request): JsonResponse {
        $user = auth()->guard('api')->user();
        try {
            if ($request->type == 1) {
                // Delete only the request token
                DB::table("oauth_access_tokens")->where("id", $user->token()['id'])->delete();
            } else {
                // Delete all user tokens
                $user->tokens->each(function ($token) use ($user) {
                    if ($token->id !== $user->token()['id']) {
                        $token->delete();
                    }
                });
            }
            return $this->return(200, 'Logged out successfully');
        } catch (Exception $e) {
            return $this->return(400, 'Couldn\'t logout using this token', [], ['e' => $e->getMessage()]);
        }
    }

    /**
     * The function checks if the user is authenticated and returns a JSON response indicating the
     * authentication status.
     * 
     * @return JsonResponse A JsonResponse object is being returned.
     */
    public function checkAuthentication(): JsonResponse {
        if (auth()->guard('api')->check()) {
            return $this->return(200, "Authenticated successfully");
        }
        return $this->return(400, "Session expired");
    }

    /**
     * The function retrieves the authenticated user details and returns a JSON response with the user
     * information.
     * 
     * @return JsonResponse a JsonResponse object.
     */
    public function getUser(): JsonResponse {
        $auth = auth()->guard('api')->user();
        $user = $this->collectUserDetails($auth, false);
        return $this->return(200, "User fetched successfully", ['user' => $user]);
    }
}
