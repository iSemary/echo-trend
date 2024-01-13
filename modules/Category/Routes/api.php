<?php

use Illuminate\Support\Facades\Route;
use modules\Category\Http\Controllers\CategoryController;

Route::get("categories", [CategoryController::class, "index"]);
