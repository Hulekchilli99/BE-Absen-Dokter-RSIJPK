<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Return dashboard counters and today's recent attendance records.
     */
    public function index(): JsonResponse
    {
        $today = today()->toDateString();

        return response()->json([
            'data' => [
                'active_doctor_count' => Doctor::query()->active()->count(),
                'today_attendance_count' => Attendance::query()
                    ->where('attendance_date', $today)
                    ->count(),
                'all_attendance_count' => Attendance::query()->count(),
                'recent_attendances' => Attendance::query()
                    ->with('doctor:id,name')
                    ->where('attendance_date', $today)
                    ->latest('checked_in_at')
                    ->latest('id')
                    ->limit(8)
                    ->get(),
            ],
        ]);
    }
}
