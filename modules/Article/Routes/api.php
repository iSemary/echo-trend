<?php

use Illuminate\Support\Facades\Route;
use modules\Article\Http\Controllers\Api\ArticleController;

Route::get("articles/{sourceSlug}/{slug}", [ArticleController::class, "show"]);
