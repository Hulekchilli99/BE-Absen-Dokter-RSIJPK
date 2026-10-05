<?php

namespace App\Services;

class LocationVerificationService
{
    /**
     * Verify whether a coordinate is inside the configured hospital radius.
     *
     * @return array{
     *     distance_meters: float,
     *     radius_meters: float,
     *     is_within_radius: bool,
     *     hospital_name: string
     * }
     */
    public function verify(float $latitude, float $longitude): array
    {
        $distanceMeters = $this->distanceInMeters(
            $latitude,
            $longitude,
            (float) config('attendance.hospital_latitude'),
            (float) config('attendance.hospital_longitude'),
        );
        $radiusMeters = (float) config('attendance.radius_meters');

        return [
            'distance_meters' => round($distanceMeters, 2),
            'radius_meters' => $radiusMeters,
            'is_within_radius' => $distanceMeters <= $radiusMeters,
            'hospital_name' => (string) config('attendance.hospital_name'),
        ];
    }

    /**
     * Calculate the great-circle distance between two coordinates.
     */
    private function distanceInMeters(
        float $latitude,
        float $longitude,
        float $targetLatitude,
        float $targetLongitude,
    ): float {
        $earthRadiusMeters = 6_371_000;
        $latitudeDelta = deg2rad($targetLatitude - $latitude);
        $longitudeDelta = deg2rad($targetLongitude - $longitude);
        $latitudeInRadians = deg2rad($latitude);
        $targetLatitudeInRadians = deg2rad($targetLatitude);

        $a = sin($latitudeDelta / 2) ** 2
            + sin($longitudeDelta / 2) ** 2
            * cos($latitudeInRadians)
            * cos($targetLatitudeInRadians);

        return 2 * $earthRadiusMeters * asin(min(1, sqrt($a)));
    }
}
