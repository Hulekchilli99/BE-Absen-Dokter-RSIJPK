<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Doctor;
use Database\Seeders\DoctorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_renames_a_legacy_doctor_name_without_losing_history(): void
    {
        $doctor = Doctor::factory()->create([
            'name' => 'dr.Gesza Utama Purta, Sp. JP',
            'is_active' => true,
        ]);
        $attendance = Attendance::factory()->create(['doctor_id' => $doctor->id]);

        $this->seed(DoctorSeeder::class);

        $this->assertDatabaseHas('doctors', [
            'id' => $doctor->id,
            'name' => 'dr. Gesza Utama Putra, Sp.JP',
            'is_active' => true,
        ]);
        $this->assertDatabaseMissing('doctors', ['name' => 'dr.Gesza Utama Purta, Sp. JP']);
        $this->assertDatabaseHas('attendances', [
            'id' => $attendance->id,
            'doctor_id' => $doctor->id,
        ]);
    }

    public function test_seeder_merges_a_duplicate_into_the_active_roster_row(): void
    {
        $rosterDoctor = Doctor::factory()->create([
            'name' => 'dr.Gesza Utama Purta, Sp. JP',
            'is_active' => true,
        ]);
        $duplicate = Doctor::factory()->inactive()->create([
            'name' => 'dr. Gesza Utama Putra, Sp.JP',
        ]);

        $rosterAttendance = Attendance::factory()->create(['doctor_id' => $rosterDoctor->id]);
        $duplicateSameDay = Attendance::factory()->create(['doctor_id' => $duplicate->id]);
        $duplicateEarlier = Attendance::factory()->create([
            'doctor_id' => $duplicate->id,
            'attendance_date' => today()->subDay()->toDateString(),
        ]);

        $this->seed(DoctorSeeder::class);

        $doctor = Doctor::query()
            ->where('name', 'dr. Gesza Utama Putra, Sp.JP')
            ->sole();

        $this->assertSame($rosterDoctor->id, $doctor->id);
        $this->assertTrue($doctor->is_active);
        $this->assertDatabaseMissing('doctors', ['name' => 'dr.Gesza Utama Purta, Sp. JP']);
        $this->assertDatabaseHas('attendances', [
            'id' => $rosterAttendance->id,
            'doctor_id' => $doctor->id,
        ]);
        $this->assertDatabaseHas('attendances', [
            'id' => $duplicateEarlier->id,
            'doctor_id' => $doctor->id,
        ]);
        $this->assertDatabaseMissing('attendances', ['id' => $duplicateSameDay->id]);
    }

    public function test_seeder_merges_leftover_roster_duplicates_with_malformed_titles(): void
    {
        $duplicates = [
            'dr. Umi Sjarqiyah' => 'dr. Umi Sjarqiah, Sp.KFR, MKM',
            'dr. Evi Rachmawati Nur Hidayati, Sp.KFR' => 'dr. Evi Rachmawati Nur Hidayati, Sp.KFR, Ger(K), FIPM(USG), Ph.D',
            'DR.dr. Flora Eka Sari' => 'dr. Flora Eka Sari, Sp.P(K) Onk',
            'dr. MAULANA SURYAMIN' => 'dr. Maulana Suryamin, Sp.PD-KGEH',
            'dr. IKA FITRIANA,SpPD,KGer' => 'dr. Ika Fitriana, Sp.PD, (K) Ger',
            'dr. Irwan Ramli, Sp. Rad(K),Onk,Rad' => 'dr. dr. Irwan Ramli, Sp.Onk.Rad (RAPI), Subsp. A.P (K)',
            'DR RINI ANDRIANI SP.N' => 'dr. dr. Rini Andriani, Sp.N, Subsp.N-Onk(K)',
        ];

        foreach (array_keys($duplicates) as $legacyName) {
            Doctor::factory()->inactive()->create(['name' => $legacyName]);
        }

        $orphanAttendance = Attendance::factory()->create([
            'doctor_id' => Doctor::query()->where('name', 'DR RINI ANDRIANI SP.N')->sole()->id,
        ]);

        $this->seed(DoctorSeeder::class);

        foreach ($duplicates as $legacyName => $canonicalName) {
            $this->assertDatabaseMissing('doctors', ['name' => $legacyName]);
            $this->assertDatabaseHas('doctors', [
                'name' => $canonicalName,
                'is_active' => true,
            ]);
        }

        $this->assertSame(
            Doctor::query()->where('name', 'dr. dr. Rini Andriani, Sp.N, Subsp.N-Onk(K)')->sole()->id,
            $orphanAttendance->fresh()->doctor_id,
        );
    }

    public function test_seeder_removes_leftover_rows_without_a_title(): void
    {
        Doctor::factory()->inactive()->create(['name' => 'Kusdiantomo']);

        $this->seed(DoctorSeeder::class);

        $this->assertDatabaseMissing('doctors', ['name' => 'Kusdiantomo']);
    }

    public function test_seeder_keeps_a_leftover_row_that_still_has_attendance_history(): void
    {
        $doctor = Doctor::factory()->inactive()->create(['name' => 'Kusdiantomo']);
        $attendance = Attendance::factory()->create(['doctor_id' => $doctor->id]);

        $this->seed(DoctorSeeder::class);

        $this->assertDatabaseHas('doctors', [
            'id' => $doctor->id,
            'name' => 'Kusdiantomo',
        ]);
        $this->assertDatabaseHas('attendances', [
            'id' => $attendance->id,
            'doctor_id' => $doctor->id,
        ]);
    }

    public function test_seeder_keeps_every_name_formatted_consistently(): void
    {
        $this->seed(DoctorSeeder::class);

        $names = Doctor::query()->orderBy('id')->pluck('name');

        $this->assertNotEmpty($names);

        foreach ($names as $name) {
            $this->assertMatchesRegularExpression('/^(?:dr\. dr\.|dr\.|drg\.) [A-Z]/u', $name, "Title of [{$name}] is not valid.");
            $this->assertDoesNotMatchRegularExpression('/\s,|,\S| {2}|^\s|\s$/u', $name, "Spacing of [{$name}] is not valid.");
        }
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed(DoctorSeeder::class);
        $seededCount = Doctor::query()->count();

        $this->seed(DoctorSeeder::class);

        $this->assertSame($seededCount, Doctor::query()->count());
        $this->assertSame(
            $seededCount,
            Doctor::query()->where('is_active', true)->count(),
        );
    }
}
