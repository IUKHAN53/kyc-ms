<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\AuditorController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ConversionController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\GroupController;
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

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // groups
        Route::resource('/groups', GroupController::class);

        // users
        Route::resource('agents', UserController::class);

        // Supervisors
         Route::resource('supervisors', SupervisorController::class);

        // Auditors
         Route::resource('auditors', AuditorController::class);

        // Clients
        Route::resource('clients', ClientController::class);

        // Conversions
         Route::resource('sales', ConversionController::class);

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

require __DIR__ . '/auth.php';
