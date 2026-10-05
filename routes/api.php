<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DoctorController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('api.login');
Route::get('/doctors', [DoctorController::class, 'index'])->name('api.doctors.index');
Route::post('/attendances', [AttendanceController::class, 'store'])
    ->middleware('throttle:30,1')
    ->name('api.attendances.store');

// Protected admin routes
Route::middleware('auth.api')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('api.dashboard');

    Route::get('/attendances/export', [AttendanceController::class, 'export'])->name('api.attendances.export');
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('api.attendances.index');

    Route::post('/doctors', [DoctorController::class, 'store'])->name('api.doctors.store');
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('api.doctors.update');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('api.doctors.destroy');
});
