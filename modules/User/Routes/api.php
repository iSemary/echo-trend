<?php

use Illuminate\Support\Facades\Route;
use modules\User\Http\Controllers\Api\AuthController;
use modules\User\Http\Controllers\Api\UserController;

/**
 *  Authentication Routes
 */
Route::group(['prefix' => 'auth'], function () {
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get("check", [AuthController::class, "checkAuthentication"]);

        Route::get("profile", [UserController::class, "getProfile"]);
        Route::post("profile", [UserController::class, "updateProfile"]);

        Route::post("logout", [AuthController::class, "logout"]);
    });
});
