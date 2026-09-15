<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\VisitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [ApiAuthController::class, 'login']);

Route::post('visitors', [VisitorController::class, 'store'])->name('visitors.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ApiAuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('visitors', VisitorController::class)
        ->only(['index', 'show', 'update', 'destroy']);
});
