<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        private readonly ?string $dateFrom = null,
        private readonly ?string $dateTo = null,
        private readonly ?int $doctorId = null,
    ) {}

    /**
     * Build the filtered attendance query used by the XLSX writer.
     *
     * A unique ID tie-breaker keeps chunked exports deterministic.
     *
     * @return Builder<Attendance>
     */
    public function query(): Builder
    {
        return Attendance::query()
            ->with('doctor:id,name')
            ->when($this->dateFrom && $this->dateTo, function (Builder $query): void {
                $query->whereBetween('attendance_date', [
                    $this->dateFrom.' 00:00:00',
                    $this->dateTo.' 23:59:59',
                ]);
            })
            ->when($this->dateFrom && ! $this->dateTo, function (Builder $query): void {
                $query->where('attendance_date', '>=', $this->dateFrom.' 00:00:00');
            })
            ->when(! $this->dateFrom && $this->dateTo, function (Builder $query): void {
                $query->where('attendance_date', '<=', $this->dateTo.' 23:59:59');
            })
            ->when($this->doctorId, function (Builder $query, int $doctorId): void {
                $query->where('doctor_id', $doctorId);
            })
            ->orderByDesc('attendance_date')
            ->orderByDesc('checked_in_at')
            ->orderByDesc('id');
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Waktu',
            'Dokter',
            'Tempat',
            'Jarak dari RS',
            'Status Lokasi',
            'Akurasi GPS',
            'Link Google Maps',
        ];
    }

    /**
     * @return array<int, mixed>
     */
    public function map(mixed $row): array
    {
        /** @var Attendance $attendance */
        $attendance = $row;
        $checkedInAt = $attendance->checked_in_at?->timezone(config('app.timezone'));
        $distance = round((float) $attendance->distance_meters);
        $accuracy = $attendance->accuracy_meters !== null ? round((float) $attendance->accuracy_meters) : null;

        $status = 'Sesuai (Area inti RS)';
        if ($accuracy !== null && $accuracy > 50) {
            $status = 'Perlu Dicek (GPS Lemah)';
        } elseif ($distance > 150) {
            $status = 'Batas Luar Radius';
        }

        $mapUrl = "https://www.google.com/maps?q={$attendance->latitude},{$attendance->longitude}";

        return [
            $attendance->attendance_date?->format('d/m/Y') ?? $checkedInAt?->format('d/m/Y'),
            $checkedInAt?->format('H:i:s') ? $checkedInAt->format('H:i:s').' WIB' : '-',
            $this->safeSpreadsheetText($attendance->doctor?->name ?? '-'),
            'RSIJ Pondok Kopi',
            $distance.' meter',
            $status,
            $accuracy !== null ? "± {$accuracy} m" : '-',
            $mapUrl,
        ];
    }

    /**
     * Style the header row for a readable spreadsheet export.
     *
     * @return array<int|string, array<string, mixed>>
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '0F766E'],
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ],
        ];
    }

    /**
     * Prevent doctor names from being interpreted as spreadsheet formulas.
     */
    private function safeSpreadsheetText(string $value): string
    {
        if (preg_match('/^[=+\-@\t\r]/u', $value) === 1) {
            return "'{$value}";
        }

        return $value;
    }
}
