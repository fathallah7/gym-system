<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('/member', MemberController::class);

});

require __DIR__ . '/auth.php';