<?php

use Illuminate\Support\Facades\Route;
use modules\Category\Http\Controllers\Api\CategoryController;

// All Categories
Route::get("categories", [CategoryController::class, "index"]);
// Articles By Category Slug
Route::get("categories/{categorySlug}/articles", [CategoryController::class, "articles"]);
