<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use modules\User\Entities\User;
use stdClass;

class ApiController extends Controller {
    /**
     * The function returns a JSON response with a status code, message, data, errors, and timestamp.
     * 
     * @param int status The status parameter is an integer that represents the HTTP status code of the
     * response. It indicates the success or failure of the request.
     * @param string message The "message" parameter is a string that represents a custom message that you
     * want to include in the response. It can be used to provide additional information or instructions to
     * the client.
     * @param array data The `` parameter is an array that contains any additional data that you want
     * to include in the response. This can be any information that you want to send back to the client.
     * @param array errors The `errors` parameter is an array that contains any error messages or
     * information related to the request or operation. It can be used to provide additional details about
     * any errors that occurred during the execution of the code.
     * 
     * @return JsonResponse a JsonResponse object.
     */
    public function return(int $status, string $message = '', array $data = [], array $errors = [], mixed $debug = []): JsonResponse {
        $response = new stdClass();
        $response->status = $status;
        $response->success = $status == 200 ? true : false;
        $response->message = $message;
        $response->data = $data;
        $response->errors = $errors;
        $response->timestamp = time();
        if (env("APP_DEBUG")) $response->debug = $debug;
        return response()->json($response, $status);
    }

    /**
     * The function returns a JSON response with a status code of 403 and a message of "Unauthenticated".
     * 
     * @return JsonResponse A JsonResponse object is being returned.
     */
    public function returnUnAuthenticated(): JsonResponse {
        return $this->return(403, "Unauthenticated");
    }

    /**
     * The function returns a JSON response with a status code of 401 and a message of "Unauthorized".
     * 
     * @return JsonResponse A JsonResponse object is being returned.
     */
    public function returnUnAuthorized(): JsonResponse {
        return $this->return(401, "Unauthorized");
    }

    /**
     * Get the authenticated user from the API guard.
     *
     * @return User|null The authenticated user
     */
    public function getAuthenticatedUser(): ?User {
        return auth()->guard('api')->user();
    }
}
