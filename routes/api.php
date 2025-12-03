<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * @scramble
 * @group Authentication
 * @auth cookie
 */
Route::get('/user', function (Request $request) {
    return \App\Http\Resources\UserResource::make($request->user());
})->middleware('auth:sanctum');

Route::middleware(['throttle:auth'])->prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
    });
});
