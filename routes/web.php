<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;

// Landing awal
Route::get('/', function () {
    return view('welcome');
});

// === DASHBOARD ROLE ===

// USER
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard.user');
});

// ADMIN
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard.admin');
});

// SUPERADMIN
Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('dashboard.superadmin');

    Route::get('/manage/admin', function () {
        return 'Kelola Admin & User';
    })->name('manage.admin');
});

// === MANAGEMENT ===

// Admin + Superadmin bisa kelola user
Route::middleware(['auth', 'verified', 'role:admin,superadmin'])->group(function () {
    Route::get('/manage/user', function () {
        return 'Kelola User';
    })->name('manage.user');
});

// === SOCIALITE ===
Route::get('auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback']);

// === PROFILE ===
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
