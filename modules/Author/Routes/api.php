<?php

use Illuminate\Support\Facades\Route;
use modules\Author\Http\Controllers\Api\AuthorController;

Route::get("authors", [AuthorController::class, "index"]);

Route::get("authors/{sourceSlug}/{authorSlug}/articles", [AuthorController::class, "articles"]);
