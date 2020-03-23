<?php

return [
    'driver' => env('WEATHER_DRIVER', 'yandex'),

    'drivers' => [
        'here' => [
            'app_code' => env('WEATHER_HERE_CODE'),
            'app_id' => env('WEATHER_HERE_ID'),
            'lat' => env('LAT_DEFAULT'),
            'lng' => env('LNG_DEFAULT')
        ],
    ],
];