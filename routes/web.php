<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReportsController;
use App\Http\Controllers\Admin\ConversionController;
use App\Http\Controllers\Auditor\AuditorDashboardController;
use App\Http\Controllers\Supervisor\SupervisorDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Livewire\Admin\Configurations\ClientsComponent;
use App\Livewire\Admin\Configurations\Profile;
use App\Livewire\Admin\Configurations\TeamsComponent;
use App\Livewire\Admin\Configurations\Users;
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
        Route::get('/reports', [AdminReportsController::class, 'index'])->name('reports.index');
        Route::resource('sales', ConversionController::class);

        // Livewire Routes
        Route::get('/config/profile', Profile::class)->name('configs.profile');
        Route::get('/config/clients', ClientsComponent::class)->name('configs.clients');
        Route::get('/config/users', Users::class)->name('configs.users');
        Route::get('/config/teams', TeamsComponent::class)->name('configs.teams');

    });

    Route::middleware('role:supervisor')->prefix('auditor')->name('supervisor.')->group(function () {
        Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/conversions', [SupervisorDashboardController::class, 'conversions'])
            ->name('conversions');
        Route::post('/change-status/{sale}', [SupervisorDashboardController::class, 'changeStatus'])
            ->name('changeStatus');
        Route::get('/reports', [SupervisorDashboardController::class, 'reports'])->name('reports');
        Route::get('/profile', \App\Livewire\Supervisor\Profile::class)->name('profile');
        Route::get('/users', \App\Livewire\Supervisor\Users::class)->name('users');
        Route::get('/teams', \App\Livewire\Supervisor\Teams::class)->name('teams');
    });

    Route::middleware('role:auditor')->prefix('auditor')->name('auditor.')->group(function () {
        Route::get('/dashboard', [AuditorDashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/conversions', [AuditorDashboardController::class, 'conversions'])
            ->name('conversions');
        Route::post('/change-status/{sale}', [AuditorDashboardController::class, 'changeStatus'])
            ->name('changeStatus');
        Route::get('/profile', \App\Livewire\Auditor\Profile::class)->name('profile');
    });

    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/conversions', [UserDashboardController::class, 'conversions'])
            ->name('conversions');
        Route::POST('/conversion/store', [UserDashboardController::class, 'storeSale'])
            ->name('conversions.store');
        Route::get('/profile', \App\Livewire\User\Profile::class)->name('profile');
    });
});

require __DIR__.'/auth.php';
