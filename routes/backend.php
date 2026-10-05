<?php

use App\Http\Controllers\Backend\AttendanceReportController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DoctorController;
use Illuminate\Support\Facades\Route;

Route::prefix('backend')->name('backend.')->middleware('auth')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('doctors', DoctorController::class)->except(['show']);

    Route::get('/attendances/export', [AttendanceReportController::class, 'export'])
        ->name('attendances.export');
    Route::get('/attendances', [AttendanceReportController::class, 'index'])
        ->name('attendances.index');
});
