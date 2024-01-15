<?php

use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;
use modules\Article\Http\Controllers\Api\ArticleController;

/**
 * Please note that file doesn't contain all the APIs on the application
 * There's also another APIs exists in each module for ex:
 * modules/User/routes/api.php
 * modules/Category/routes/api.php
 */

// Top Headings API
Route::get("/top-headings", [HomeController::class, "topHeadings"]);

// Today's news
Route::get("/today", [ArticleController::class, "todayArticles"]);

// Search API
Route::get("search", [ArticleController::class, "find"]);

// Deeply Search API
Route::get("search/deeply", [ArticleController::class, "findDeeply"]);
