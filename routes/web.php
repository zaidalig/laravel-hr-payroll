<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'active.user'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('can:manage-hr')->group(function () {
        Route::resource('departments', DepartmentController::class)->except(['show']);
        Route::resource('employees', EmployeeController::class);
        Route::resource('attendance', AttendanceController::class)->except(['show']);
        Route::resource('leaves', LeaveRequestController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::patch('leaves/{leave}/status', [LeaveRequestController::class, 'updateStatus'])->name('leaves.status');
    });

    Route::middleware('can:manage-payroll')->group(function () {
        Route::resource('payroll', PayrollController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
        Route::patch('payroll/{payroll}/paid', [PayrollController::class, 'markPaid'])->name('payroll.paid');
        Route::get('payroll/{payroll}/print', [PayrollController::class, 'print'])->name('payroll.print');
    });

    Route::middleware('can:manage-users')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->middleware('can:manage-users')->name('activity.index');
});
