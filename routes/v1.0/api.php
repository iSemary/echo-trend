<?php

use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;

/**
 * Please note that file doesn't contain all the APIs on the application
 * There's also another APIs exists in each module for ex:
 * modules/User/routes/api.php
 * modules/Category/routes/api.php
 */

// Home API
Route::get("/", [HomeController::class, "index"]);
