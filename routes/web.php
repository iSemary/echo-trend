<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;


// Website routes
Route::get('/{any}', [AppController::class, 'index'])->where('any', '^((?!app|static).)*$');
