<?php

namespace Tests\Feature;

use App\Services\LocationVerificationService;
use Tests\TestCase;

class LocationVerificationFeatureTest extends TestCase
{
    public function test_hospital_center_is_inside_the_configured_geofence(): void
    {
        $result = app(LocationVerificationService::class)->verify(
            (float) config('attendance.hospital_latitude'),
            (float) config('attendance.hospital_longitude'),
        );

        $this->assertTrue($result['is_within_radius']);
        $this->assertSame(0.0, $result['distance_meters']);
    }

    public function test_coordinate_far_from_the_hospital_is_outside_the_geofence(): void
    {
        $result = app(LocationVerificationService::class)->verify(-6.2, 106.8);

        $this->assertFalse($result['is_within_radius']);
        $this->assertGreaterThan($result['radius_meters'], $result['distance_meters']);
    }
}
