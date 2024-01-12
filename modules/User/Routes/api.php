<?php

use Illuminate\Support\Facades\Route;
use modules\Chats\Http\Controllers\Api\AuthController;

/**
 *  Authentication Routes
 */
Route::group(['prefix' => 'auth'], function () {
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);
});
