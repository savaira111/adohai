<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

// ================== USER ==================
Route::middleware(['auth','verified','profile.complete'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.user');
    })->name('dashboard.user');
});

// ================== ADMIN ==================
Route::middleware(['auth','role:admin','verified'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard.admin');

    Route::resource('/admin/users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy'
    ]);
});

// ================== SUPERADMIN ==================
Route::middleware(['auth','role:superadmin','verified'])->group(function () {

    Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'index'])
        ->name('dashboard.superadmin');

        // Destroy Confirm
        Route::prefix('superadmin/users')->name('superadmin.users.')->group(function () {
            Route::get('/trashed', [UserManagementController::class, 'trashed'])->name('trashed');
            Route::post('/{id}/restore', [UserManagementController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force', [UserManagementController::class, 'forceDelete'])->name('forceDelete');
        });
        
    Route::resource('/superadmin/users', UserManagementController::class)->names([
        'index' => 'superadmin.users.index',
        'create' => 'superadmin.users.create',
        'store' => 'superadmin.users.store',
        'show' => 'superadmin.users.show',
        'edit' => 'superadmin.users.edit',
        'update' => 'superadmin.users.update',
        'destroy' => 'superadmin.users.destroy',
    ]);

    Route::delete('/superadmin/users/{id}/destroy-confirm', [UserManagementController::class, 'destroyConfirm'])
        ->name('superadmin.users.destroy.confirm');

    // Trashed / Restore / Force Delete

});

// ================== LOGIN (Google) ==================
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->name('social.callback');

// ================== PROFILE ==================
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
