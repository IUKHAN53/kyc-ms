<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auditor\AuditorDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Supervisor\SupervisorDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/bypass/{role}', function ($role) {
    $user = \App\Models\User::query()->where('role', $role)->first();

    auth()->login($user);

    return redirect(redirectToDashboard($user));
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        $user = auth()->user();

        return redirect(redirectToDashboard($user));
    })->name('dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
    });

    Route::middleware('role:supervisor')->group(function () {
        Route::get('/supervisor/dashboard', [SupervisorDashboardController::class, 'index'])
            ->name('supervisor.dashboard');
    });

    Route::middleware('role:auditor')->group(function () {
        Route::get('/auditor/dashboard', [AuditorDashboardController::class, 'index'])
            ->name('auditor.dashboard');
    });

    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
            ->name('user.dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
