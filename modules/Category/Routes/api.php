<?php

use Illuminate\Support\Facades\Route;
use modules\Category\Http\Controllers\Api\CategoryController;

Route::get("categories", [CategoryController::class, "index"]);
