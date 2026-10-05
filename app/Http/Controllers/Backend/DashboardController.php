<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Doctor;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the backend dashboard.
     */
    public function index(): View
    {
        $today = now()->toDateString();
        $activeDoctorCount = Doctor::query()->active()->count();
        $todayAttendanceCount = Attendance::query()
            ->where('attendance_date', $today)
            ->count();

        return view('backend.dashboard', [
            'activeDoctorCount' => $activeDoctorCount,
            'todayAttendanceCount' => $todayAttendanceCount,
            'allAttendanceCount' => Attendance::query()->count(),
            'recentAttendances' => Attendance::query()
                ->with('doctor')
                ->where('attendance_date', $today)
                ->latest('checked_in_at')
                ->latest('id')
                ->limit(8)
                ->get(),
        ]);
    }
}
