<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\MooraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CriteriaController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InternshipController as AdminInternshipController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Admin\AdminProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Internship Management
    Route::post('internships/bulk', [\App\Http\Controllers\InternshipController::class, 'bulkStore'])->name('internships.bulk');
    Route::resource('internships', \App\Http\Controllers\InternshipController::class);
    
    // MOORA Calculation
    Route::get('/moora', [MooraController::class, 'index'])->name('moora.index');
    Route::post('/moora/calculate', [MooraController::class, 'calculate'])->name('moora.calculate');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('criterias', CriteriaController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('internships', AdminInternshipController::class);
    
    // Split Management
    Route::resource('users', UserController::class);
    Route::resource('administrators', AdministratorController::class);

    // Admin Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
