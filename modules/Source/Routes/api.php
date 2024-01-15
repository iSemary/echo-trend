<?php

use Illuminate\Support\Facades\Route;
use modules\Source\Http\Controllers\Api\SourceController;

Route::get("sources", [SourceController::class, "index"]);

Route::get("sources/{sourceSlug}/articles", [SourceController::class, "articles"]);
