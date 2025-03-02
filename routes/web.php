<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PilotController;
use App\Http\Controllers\Admin\StartupController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PilotMiddleware;
use App\Http\Middleware\StartupMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware(RedirectIfAuthenticated::class);
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware(RedirectIfAuthenticated::class);
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:web');
});

// Admin Routes
Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Pilot Routes
Route::prefix('pilot')->middleware(PilotMiddleware::class)->group(function () {
    Route::get('/dashboard', [PilotController::class, 'dashboard'])->name('pilot.dashboard');
});

// Startup Routes
Route::prefix('startup')->middleware(StartupMiddleware::class)->group(function () {
    Route::get('/dashboard', [StartupController::class, 'dashboard'])->name('startup.dashboard');
});
