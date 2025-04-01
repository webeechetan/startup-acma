<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\PilotController;
use App\Http\Controllers\Admin\PilotCategoryController;
use App\Http\Controllers\Admin\PilotUserController;
use App\Http\Controllers\Admin\StartupController;
use App\Http\Controllers\Admin\CaseStudyController;
use App\Http\Controllers\Admin\KnowledgeSharingController;
use App\Http\Controllers\Admin\ContactController;
// Auth Routes
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware(RedirectIfAuthenticated::class);
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware(RedirectIfAuthenticated::class);
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:web');
});

// Admin Routes
Route::prefix('admin')->middleware('userType:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::prefix('pilots')->group(function () {
        Route::resource('categories', PilotCategoryController::class)->names('pilots.categories');
        Route::resource('users', PilotUserController::class)->names('pilots.users');
    });
    Route::resources([
        'seasons' => SeasonController::class,
        'pilots' => PilotController::class,
        'startups' => StartupController::class,
        'case-studies' => CaseStudyController::class,
        'knowledge-sharings' => KnowledgeSharingController::class,
        'contacts' => ContactController::class,
    ]);
});

