<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\InternshipApiController;
use App\Http\Controllers\Api\MooraApiController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthApiController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthApiController::class, 'me']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // Internship CRUD
    Route::apiResource('internships', InternshipApiController::class)->names([
        'index' => 'api.internships.index',
        'store' => 'api.internships.store',
        'show' => 'api.internships.show',
        'update' => 'api.internships.update',
        'destroy' => 'api.internships.destroy',
    ]);

    // MOORA
    Route::get('/criterias', [MooraApiController::class, 'getCriterias']);
    Route::get('/weights', [MooraApiController::class, 'getUserWeights']);
    Route::post('/moora/calculate', [MooraApiController::class, 'calculate']);
});
