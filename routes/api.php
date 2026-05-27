<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\InternshipApiController;
use App\Http\Controllers\Api\MooraApiController;

// Public Routes
Route::post('/login', [AuthApiController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('/me', [AuthApiController::class, 'me']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // Internships
    Route::get('/internships', [InternshipApiController::class, 'index']);
    Route::get('/internships/{internship}', [InternshipApiController::class, 'show']);

    // MOORA
    Route::get('/criterias', [MooraApiController::class, 'getCriterias']);
    Route::get('/weights', [MooraApiController::class, 'getUserWeights']);
    Route::post('/calculate', [MooraApiController::class, 'calculate']);
});
