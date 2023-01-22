<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiAuthController;
use App\Http\Resources\AuthUserResource;

// API Routes
Route::prefix('v1')->group(function () {
    Route::get('fetch-books', \App\Http\Controllers\BookController::class);

    // login register route
    Route::controller(ApiAuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });
    //---------Admin Routing----------
    Route::middleware(['token.check', 'auth:sanctum'])->group(function () {
        Route::get('/user', function (Request $request) {
            return new AuthUserResource($request->user());
        });
        Route::post('logout', [ApiAuthController::class, 'logout']);
    });
});
