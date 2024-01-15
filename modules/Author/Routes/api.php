<?php

use Illuminate\Support\Facades\Route;
use modules\Author\Http\Controllers\Api\AuthorController;

Route::get("authors", [AuthorController::class, "index"]);

Route::get("authors/{authorSlug}/articles", [AuthorController::class, "articles"]);
