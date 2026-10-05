<?php

return [
    'hospital_name' => env('ATTENDANCE_HOSPITAL_NAME', 'Rumah Sakit Islam Jakarta Pondok Kopi'),
    'hospital_address' => env(
        'ATTENDANCE_HOSPITAL_ADDRESS',
        'Jalan Raya Pondok Kopi, Duren Sawit, Jakarta Timur',
    ),
    'hospital_latitude' => (float) env('ATTENDANCE_HOSPITAL_LATITUDE', -6.2202649),
    'hospital_longitude' => (float) env('ATTENDANCE_HOSPITAL_LONGITUDE', 106.9399345),
    'radius_meters' => (float) env('ATTENDANCE_RADIUS_METERS', 250),
];
