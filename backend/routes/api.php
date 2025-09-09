<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('/member', MemberController::class);

    Route::apiResource('/plans', PlanController::class);

    Route::apiResource('/memberships', MembershipController::class);
    
    Route::apiResource('/invoices', InvoicesController::class);

    Route::get('/dashboard' , [DashboardController::class , 'index']);

});

require __DIR__ . '/auth.php';