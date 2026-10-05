<?php

namespace App\Http\Controllers\Api;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceReportRequest;
use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Services\LocationVerificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttendanceController extends Controller
{
    /**
     * Return a filtered, paginated attendance report.
     */
    public function index(AttendanceReportRequest $request): JsonResponse
    {
        $filters = $this->filtersWithDefaults($request->validated());
        $attendances = $this->filteredQuery($filters)
            ->paginate(15)
            ->withQueryString();

        return response()->json([
            'data' => $attendances,
            'filters' => $filters,
        ]);
    }

    /**
     * Store an attendance after validating the device location server-side.
     */
    public function store(
        StoreAttendanceRequest $request,
        LocationVerificationService $locationVerificationService,
    ): JsonResponse {
        $validated = $request->validated();
        $location = $locationVerificationService->verify(
            (float) $validated['latitude'],
            (float) $validated['longitude'],
        );

        if (! $location['is_within_radius']) {
            return response()->json([
                'message' => 'Absensi ditolak karena lokasi berada di luar area rumah sakit.',
                'errors' => [
                    'location' => [sprintf(
                        'Anda berada sekitar %s meter dari %s. Maksimal radius yang diizinkan adalah %s meter.',
                        number_format($location['distance_meters'], 0, ',', '.'),
                        $location['hospital_name'],
                        number_format($location['radius_meters'], 0, ',', '.'),
                    )],
                ],
                'location' => $location,
            ], 422);
        }

        $checkedInAt = now();
        $attendanceDate = $checkedInAt->toDateString();
        $doctorId = (int) $validated['doctor_id'];

        if (Attendance::query()
            ->where('doctor_id', $doctorId)
            ->where('attendance_date', $attendanceDate)
            ->exists()) {
            return response()->json([
                'message' => 'Dokter ini sudah melakukan absensi hari ini.',
                'errors' => [
                    'doctor_id' => ['Dokter ini sudah melakukan absensi hari ini.'],
                ],
            ], 422);
        }

        try {
            $attendance = Attendance::create([
                'doctor_id' => $doctorId,
                'attendance_date' => $attendanceDate,
                'checked_in_at' => $checkedInAt,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'accuracy_meters' => $validated['accuracy_meters'] ?? null,
                'distance_meters' => $location['distance_meters'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])->load('doctor:id,name');
        } catch (UniqueConstraintViolationException) {
            return response()->json([
                'message' => 'Dokter ini sudah melakukan absensi hari ini.',
                'errors' => [
                    'doctor_id' => ['Dokter ini sudah melakukan absensi hari ini.'],
                ],
            ], 422);
        }

        return response()->json([
            'message' => 'Absensi berhasil disimpan.',
            'data' => $attendance,
        ], 201);
    }

    /**
     * Download the filtered attendance report as an Excel workbook.
     */
    public function export(AttendanceReportRequest $request): BinaryFileResponse
    {
        $filters = $this->filtersWithDefaults($request->validated());
        $dateLabel = $filters['date_from'] === $filters['date_to']
            ? $filters['date_from']
            : $filters['date_from'].'-'.$filters['date_to'];

        return Excel::download(
            new AttendanceExport(
                $filters['date_from'],
                $filters['date_to'],
                $filters['doctor_id'],
            ),
            'rekap-absensi-dokter-'.$dateLabel.'.xlsx',
        );
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return Builder<Attendance>
     */
    private function filteredQuery(array $filters): Builder
    {
        return Attendance::query()
            ->with('doctor:id,name')
            ->whereBetween('attendance_date', [
                $filters['date_from'].' 00:00:00',
                $filters['date_to'].' 23:59:59',
            ])
            ->when($filters['doctor_id'], function (Builder $query, int $doctorId): void {
                $query->where('doctor_id', $doctorId);
            })
            ->latest('attendance_date')
            ->latest('checked_in_at')
            ->latest('id');
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return array{date_from: string, date_to: string, doctor_id: ?int}
     */
    private function filtersWithDefaults(array $filters): array
    {
        return [
            'date_from' => (string) ($filters['date_from'] ?? now()->startOfMonth()->toDateString()),
            'date_to' => (string) ($filters['date_to'] ?? today()->toDateString()),
            'doctor_id' => isset($filters['doctor_id']) ? (int) $filters['doctor_id'] : null,
        ];
    }
}
