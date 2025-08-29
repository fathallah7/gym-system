<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('/member', MemberController::class);
    Route::apiResource('/plan', PlanController::class);

});

require __DIR__ . '/auth.php';