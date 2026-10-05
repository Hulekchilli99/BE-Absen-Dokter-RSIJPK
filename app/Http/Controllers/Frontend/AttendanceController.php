<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\Doctor;
use App\Services\LocationVerificationService;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Show the attendance form.
     */
    public function create(): View
    {
        $doctors = Doctor::query()
            ->active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('frontend.attendance.create', [
            'doctors' => $doctors,
            'hospital' => [
                'name' => config('attendance.hospital_name'),
                'address' => config('attendance.hospital_address'),
                'latitude' => config('attendance.hospital_latitude'),
                'longitude' => config('attendance.hospital_longitude'),
                'radius_meters' => config('attendance.radius_meters'),
            ],
        ]);
    }

    /**
     * Save a doctor's attendance after verifying the submitted location.
     */
    public function store(
        StoreAttendanceRequest $request,
        LocationVerificationService $locationVerificationService,
    ): RedirectResponse {
        $validated = $request->validated();
        $location = $locationVerificationService->verify(
            (float) $validated['latitude'],
            (float) $validated['longitude'],
        );

        if (! $location['is_within_radius']) {
            return back()
                ->withInput()
                ->withErrors([
                    'location' => sprintf(
                        'Absensi ditolak. Anda berada sekitar %s meter dari %s. Maksimal radius yang diizinkan adalah %s meter.',
                        number_format($location['distance_meters'], 0, ',', '.'),
                        $location['hospital_name'],
                        number_format($location['radius_meters'], 0, ',', '.'),
                    ),
                ]);
        }

        $attendanceDate = now()->toDateString();
        $doctorId = (int) $validated['doctor_id'];

        if (Attendance::query()
            ->where('doctor_id', $doctorId)
            ->where('attendance_date', $attendanceDate)
            ->exists()) {
            return back()
                ->withInput()
                ->withErrors(['doctor_id' => 'Dokter ini sudah melakukan absensi hari ini.']);
        }

        try {
            Attendance::create([
                'doctor_id' => $doctorId,
                'attendance_date' => $attendanceDate,
                'checked_in_at' => now(),
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'accuracy_meters' => $validated['accuracy_meters'] ?? null,
                'distance_meters' => $location['distance_meters'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (UniqueConstraintViolationException) {
            return back()
                ->withInput()
                ->withErrors(['doctor_id' => 'Dokter ini sudah melakukan absensi hari ini.']);
        }

        return redirect()
            ->route('frontend.attendance.create')
            ->with('success', 'Absensi berhasil disimpan. Terima kasih.');
    }
}
