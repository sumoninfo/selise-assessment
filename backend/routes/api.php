<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiAuthController;
use App\Http\Resources\AuthUserResource;

// API Routes
Route::prefix('v1')->group(function () {
    //
    Route::get('fetch-books', \App\Http\Controllers\BookController::class, 'index');

    // login register route
    Route::controller(ApiAuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    //---------Admin Routing----------
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', function (Request $request) {
            return new AuthUserResource($request->user());
        });
        Route::controller(ApiAuthController::class)->group(function () {
            Route::post('/logout', 'logout');
            Route::post('/refresh-token', 'refreshToken');
        });

        Route::get('/dashboard-data', \App\Http\Controllers\DashboardController::class);

    });
});
