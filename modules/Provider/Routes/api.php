<?php

use Illuminate\Support\Facades\Route;
use modules\Provider\Http\Controllers\Api\ProviderController;



Route::group(['prefix' => 'providers'], function () {
    // Temporary API [For Testing Only]
    Route::get("sync", [ProviderController::class, "sync"]);
    // Register new service provider
    Route::post("register", [ProviderController::class, "register"]);
});
