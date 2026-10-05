<?php

use App\Http\Controllers\Frontend\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AttendanceController::class, 'create'])
    ->name('frontend.attendance.create');

Route::post('/absensi', [AttendanceController::class, 'store'])
    ->middleware('throttle:30,1')
    ->name('frontend.attendance.store');
