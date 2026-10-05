<?php

namespace Tests\Feature;

use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAttendanceFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_stores_attendance_when_location_is_inside_the_radius(): void
    {
        $doctor = Doctor::factory()->create();

        $response = $this->postJson(route('api.attendances.store'), [
            'doctor_id' => $doctor->id,
            'latitude' => config('attendance.hospital_latitude'),
            'longitude' => config('attendance.hospital_longitude'),
            'accuracy_meters' => 7.5,
        ]);

        $response->assertCreated()
            ->assertJsonPath('message', 'Absensi berhasil disimpan.')
            ->assertJsonPath('data.doctor.id', $doctor->id);
        $this->assertDatabaseHas('attendances', [
            'doctor_id' => $doctor->id,
            'distance_meters' => 0,
        ]);
    }

    public function test_api_rejects_attendance_when_location_is_outside_the_radius(): void
    {
        $doctor = Doctor::factory()->create();

        $response = $this->postJson(route('api.attendances.store'), [
            'doctor_id' => $doctor->id,
            'latitude' => (float) config('attendance.hospital_latitude') + 0.01,
            'longitude' => config('attendance.hospital_longitude'),
            'accuracy_meters' => 7.5,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('location');
        $this->assertDatabaseCount('attendances', 0);
    }

    public function test_api_lists_only_active_doctors_for_the_public_attendance_form(): void
    {
        $activeDoctor = Doctor::factory()->create(['name' => 'dr. Aktif API']);
        Doctor::factory()->inactive()->create(['name' => 'dr. Nonaktif API']);

        $response = $this->getJson(route('api.doctors.index'));

        $response->assertOk()
            ->assertJsonPath('data.0.id', $activeDoctor->id)
            ->assertJsonMissing(['name' => 'dr. Nonaktif API']);
    }
}
