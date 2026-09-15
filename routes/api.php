<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class);

Route::post('login', [ApiAuthController::class, 'login']);

Route::post('visitors', [VisitorController::class, 'store'])->name('visitors.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ApiAuthController::class, 'logout']);

    Route::get('/user', [ApiAuthController::class, 'user']);

    Route::apiResource('visitors', VisitorController::class)
        ->only(['index', 'show', 'update', 'destroy']);
});
