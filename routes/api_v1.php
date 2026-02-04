<?php

use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Here are the version 1 API routes for the application.
| All routes are prefixed with /api/v1 and require authentication.
|
*/

Route::middleware('auth:sanctum')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('v1.dashboard');

    // Members Resource
    Route::apiResource('members', MemberController::class)
        ->names([
            'index' => 'v1.members.index',
            'store' => 'v1.members.store',
            'show' => 'v1.members.show',
            'update' => 'v1.members.update',
            'destroy' => 'v1.members.destroy',
        ]);

    // Plans Resource
    Route::apiResource('plans', PlanController::class)
        ->names([
            'index' => 'v1.plans.index',
            'store' => 'v1.plans.store',
            'show' => 'v1.plans.show',
            'update' => 'v1.plans.update',
            'destroy' => 'v1.plans.destroy',
        ]);

    // Memberships Resource
    Route::apiResource('memberships', MembershipController::class)
        ->names([
            'index' => 'v1.memberships.index',
            'store' => 'v1.memberships.store',
            'show' => 'v1.memberships.show',
            'update' => 'v1.memberships.update',
            'destroy' => 'v1.memberships.destroy',
        ]);

    // Membership Attendance
    Route::put('/memberships/{membership}/attendance', [AttendancesController::class, 'update'])
        ->name('v1.memberships.attendance');

    // Invoices Resource
    Route::apiResource('invoices', InvoicesController::class)
        ->names([
            'index' => 'v1.invoices.index',
            'store' => 'v1.invoices.store',
            'show' => 'v1.invoices.show',
            'update' => 'v1.invoices.update',
            'destroy' => 'v1.invoices.destroy',
        ]);
});

require __DIR__ . '/auth.php';
