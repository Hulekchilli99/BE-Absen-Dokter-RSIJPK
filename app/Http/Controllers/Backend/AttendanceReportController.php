<?php

namespace App\Http\Controllers\Backend;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceReportRequest;
use App\Models\Attendance;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttendanceReportController extends Controller
{
    public function index(AttendanceReportRequest $request): View
    {
        $filters = $this->filtersWithDefaults($request->validated());
        $attendanceQuery = $this->filteredQuery($filters);
        $attendances = $attendanceQuery->paginate(15)->withQueryString();

        return view('backend.attendances.index', [
            'attendances' => $attendances,
            'doctors' => Doctor::query()->orderBy('name')->get(['id', 'name']),
            'filters' => $filters,
            'totalAttendance' => (clone $attendanceQuery)->reorder()->count(),
        ]);
    }

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
            ->orderByDesc('attendance_date')
            ->orderByDesc('checked_in_at')
            ->orderByDesc('id');
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
