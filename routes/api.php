<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\InternshipApiController;
use App\Http\Controllers\Api\MooraApiController;
use App\Http\Controllers\Api\CategoryApiController;

// Public Routes
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/google-login', [AuthApiController::class, 'googleLogin']);
Route::post('/forgot-password', [AuthApiController::class, 'forgotPassword']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Dashboard Data
    Route::get('/dashboard', [\App\Http\Controllers\Api\DashboardApiController::class, 'index']);

    // Auth & Profile
    Route::get('/me', [AuthApiController::class, 'me']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::post('/profile/update', [AuthApiController::class, 'updateProfile']);
    Route::post('/profile/change-password', [AuthApiController::class, 'changePassword']);

    // Categories
    Route::get('/categories', [CategoryApiController::class, 'index']);

    // Internships
    Route::get('/internships/global', [InternshipApiController::class, 'global']);
    Route::post('/internships/bulk', [InternshipApiController::class, 'bulkStore']);
    Route::apiResource('internships', InternshipApiController::class)->names('api.internships');

    // MOORA
    Route::get('/criterias', [MooraApiController::class, 'getCriterias']);
    Route::get('/weights', [MooraApiController::class, 'getUserWeights']);
    Route::post('/calculate', [MooraApiController::class, 'calculate']);
});
