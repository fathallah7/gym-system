<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| Routes are versioned and loaded from separate files.
|
*/

// API Version 1
Route::prefix('v1')->group(base_path('routes/api_v1.php'));

// Authentication Routes (no version prefix)

