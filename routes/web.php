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
use App\Http\Controllers\Admin\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Internship Management
    Route::post('internships/bulk', [\App\Http\Controllers\InternshipController::class, 'bulkStore'])->name('internships.bulk');
    Route::resource('internships', \App\Http\Controllers\InternshipController::class);
    
    // MOORA Calculation
    Route::get('/moora', [MooraController::class, 'index'])->name('moora.index');
    Route::get('/moora/history', [MooraController::class, 'history'])->name('moora.history');
    Route::get('/moora/history/{session}', [MooraController::class, 'showHistory'])->name('moora.history.show');
    Route::delete('/moora/history/{session}', [MooraController::class, 'destroySession'])->name('moora.history.destroy');
    Route::post('/moora/calculate', [MooraController::class, 'calculate'])->name('moora.calculate');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('criterias', CriteriaController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('internships', AdminInternshipController::class);
    
    // User Contributed Internships
    Route::get('user-internships', [\App\Http\Controllers\Admin\UserInternshipController::class, 'index'])->name('user-internships.index');
    Route::post('user-internships/{internship}/promote', [\App\Http\Controllers\Admin\UserInternshipController::class, 'promote'])->name('user-internships.promote');
    
    // Split Management
    Route::resource('users', UserController::class);
    Route::resource('administrators', AdministratorController::class);

    // Data Export
    Route::get('export/users', [\App\Http\Controllers\Admin\ExportController::class, 'exportUsers'])->name('export.users');
    Route::get('export/internships', [\App\Http\Controllers\Admin\ExportController::class, 'exportInternships'])->name('export.internships');
    Route::get('export/sessions', [\App\Http\Controllers\Admin\ExportController::class, 'exportSessions'])->name('export.sessions');

    // Activity Logs
    Route::get('logs', [ActivityLogController::class, 'index'])->name('logs.index');

    // User Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
