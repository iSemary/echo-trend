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
use modules\User\Entities\User;

class AuthController extends ApiController {
    public function register(RegisterRequest $request): JsonResponse {
        /* Requested data passed the validation */
        $userRequest = $request->validated();
        $email = $userRequest['email'];
        $username = strtok($email, '@');
        // Adding username to the $userRequest array
        $userRequest['username'] = $username .  Str::random(4);
        // Create new user record
        $user = User::create($userRequest);
        $response = $this->collectUserDetails($user);
        // Return Success Json Response
        return $this->return(200, 'User Registered Successfully', ['user' => $response]);
    }

    public function login(LoginRequest $request): JsonResponse {
        // Check login credentials
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            // collect user details to return in the json response
            $response = $this->collectUserDetails($user);
            // Return Success Json Response
            return $this->return(200, 'User Logged in Successfully', ['user' => $response]);
        }
    }

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

    private function generateAccessToken(User $user): string {
        return $user->createToken('web-app')->accessToken;
    }

    private function selectUserData(User $user): User {
        return $user->where("id", $user->id)->select('full_name', 'email', 'username', 'created_at')->first();
    }

    public function logout(Request $request): JsonResponse {
        $user = auth()->guard('api')->user();
        try {
            if ($request->type == 1) {
                // Delete only the request token
                DB::table("oauth_access_tokens")->where("id", $user->token()['id'])->delete();
            } else {
                // Delete all user tokens
                $user->tokens->each(function ($token, $key) use ($user) {
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
}
