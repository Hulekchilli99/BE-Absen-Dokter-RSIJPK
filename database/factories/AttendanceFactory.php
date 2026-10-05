<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::factory(),
            'attendance_date' => today()->toDateString(),
            'checked_in_at' => now(),
            'latitude' => config('attendance.hospital_latitude'),
            'longitude' => config('attendance.hospital_longitude'),
            'accuracy_meters' => 10,
            'distance_meters' => 10,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Attendance test agent',
        ];
    }
}
