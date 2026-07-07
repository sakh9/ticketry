<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProposalController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\AdminManagementController;

Route::prefix('admin')->name('admin.')->group(function () {

    // Redirect admin entry and login to main login page
    Route::get('/entry', fn () => redirect()->route('login'));
    Route::get('/login', fn () => redirect()->route('login'));

    // Auth actions (POST only - no public registration)
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login');

    // Protected routes
    Route::middleware('admin.auth')->group(function () {

        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Proposals
        Route::get('/proposals/{event}', [ProposalController::class, 'show'])->name('proposals.show');
        Route::post('/proposals/{event}/approve', [ProposalController::class, 'approve'])->name('proposals.approve');
        Route::post('/proposals/{event}/reject', [ProposalController::class, 'reject'])->name('proposals.reject');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/download-pdf', [ReportController::class, 'downloadPdf'])->name('reports.download-pdf');

        // Users
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/detail', [UserManagementController::class, 'show'])->name('users.show');
        Route::post('/users/ban', [UserManagementController::class, 'ban'])->name('users.ban');
        Route::post('/users/unban', [UserManagementController::class, 'unban'])->name('users.unban');
        Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');

        // Locations
        Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
        Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
        Route::post('/locations/{location}/toggle', [LocationController::class, 'toggle'])->name('locations.toggle');
        Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

        // Admin Management (create new admins)
        Route::get('/admins', [AdminManagementController::class, 'index'])->name('admins.index');
        Route::post('/admins', [AdminManagementController::class, 'store'])->name('admins.store');
        Route::delete('/admins/{admin}', [AdminManagementController::class, 'destroy'])->name('admins.destroy');
    });
});