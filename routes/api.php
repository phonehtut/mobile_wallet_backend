<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['throttle:auth'])->prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return \App\Http\Resources\UserResource::make($request->user());
        });
        Route::prefix('payment')->group(function () {
            Route::post('transfer', [PaymentController::class, 'transfer']);
        });
    });
});
