<?php

namespace Tests\Feature;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class AttendanceFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_presensi_form_lists_active_doctors(): void
    {
        $doctor = Doctor::factory()->create(['name' => 'dr. Budi Santoso']);
        Doctor::factory()->inactive()->create(['name' => 'dr. Tidak Aktif']);

        $response = $this->get(route('frontend.attendance.create'));

        $response->assertOk();
        $response->assertSeeText($doctor->name);
        $response->assertDontSeeText('dr. Tidak Aktif');
    }

    public function test_admin_can_add_a_doctor_to_master(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('backend.doctors.store'), [
            'name' => '  dr. Citra  Permata  ',
        ]);

        $response->assertRedirect(route('backend.doctors.index'));
        $response->assertSessionHas('success', 'Dokter berhasil ditambahkan ke master.');
        $this->assertDatabaseHas('doctors', [
            'name' => 'dr. Citra Permata',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_add_an_inactive_doctor_to_master(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('backend.doctors.store'), [
            'name' => 'dr. Dokter Nonaktif',
            'is_active' => '0',
        ]);

        $response->assertRedirect(route('backend.doctors.index'));
        $this->assertDatabaseHas('doctors', [
            'name' => 'dr. Dokter Nonaktif',
            'is_active' => false,
        ]);
    }

    public function test_attendance_is_saved_when_location_is_inside_the_hospital_radius(): void
    {
        $doctor = Doctor::factory()->create();
        $latitude = (float) config('attendance.hospital_latitude');
        $longitude = (float) config('attendance.hospital_longitude');

        $response = $this->post(route('frontend.attendance.store'), [
            'doctor_id' => $doctor->id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'accuracy_meters' => 8.5,
        ]);

        $response->assertRedirect(route('frontend.attendance.create'));
        $response->assertSessionHas('success', 'Absensi berhasil disimpan. Terima kasih.');
        $this->assertDatabaseHas('attendances', [
            'doctor_id' => $doctor->id,
            'distance_meters' => 0,
        ]);
        $this->assertTrue(
            Attendance::query()
                ->where('doctor_id', $doctor->id)
                ->whereDate('attendance_date', today())
                ->exists(),
        );
    }

    public function test_attendance_is_rejected_when_location_is_outside_the_hospital_radius(): void
    {
        $doctor = Doctor::factory()->create();

        $response = $this->from(route('frontend.attendance.create'))->post(route('frontend.attendance.store'), [
            'doctor_id' => $doctor->id,
            'latitude' => (float) config('attendance.hospital_latitude') + 0.01,
            'longitude' => (float) config('attendance.hospital_longitude'),
            'accuracy_meters' => 8.5,
        ]);

        $response->assertRedirect(route('frontend.attendance.create'));
        $response->assertSessionHasErrors('location');
        $this->assertDatabaseCount('attendances', 0);
    }

    public function test_a_doctor_can_only_attend_once_per_day(): void
    {
        $doctor = Doctor::factory()->create();
        $payload = [
            'doctor_id' => $doctor->id,
            'latitude' => config('attendance.hospital_latitude'),
            'longitude' => config('attendance.hospital_longitude'),
            'accuracy_meters' => 8,
        ];

        $this->post(route('frontend.attendance.store'), $payload)->assertRedirect(route('frontend.attendance.create'));

        $response = $this->from(route('frontend.attendance.create'))->post(route('frontend.attendance.store'), $payload);

        $response->assertRedirect(route('frontend.attendance.create'));
        $response->assertSessionHasErrors('doctor_id');
        $this->assertDatabaseCount('attendances', 1);
    }

    public function test_report_can_be_downloaded_as_an_excel_export(): void
    {
        $admin = User::factory()->create();
        $attendance = Attendance::factory()->create();
        Excel::fake();

        $date = $attendance->attendance_date->toDateString();
        $response = $this->actingAs($admin)->get(route('backend.attendances.export', [
            'date_from' => $date,
            'date_to' => $date,
        ]));

        $response->assertOk();
        Excel::assertDownloaded(
            'rekap-absensi-dokter-'.$date.'.xlsx',
            static fn (AttendanceExport $export): bool => $export->query()->whereKey($attendance->id)->exists(),
        );
    }
}
