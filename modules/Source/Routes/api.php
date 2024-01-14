<?php

use Illuminate\Support\Facades\Route;
use modules\Source\Http\Controllers\Api\SourceController;

Route::get("sources", [SourceController::class, "index"]);
