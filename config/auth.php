<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'reception' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'lab_technician' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'pharmacist' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'patient' => [
            'driver' => 'session',
            'provider' => 'patients',
        ],

        'nurse' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'health_officer' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'patients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Patient::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'patients' => [
            'provider' => 'patients',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
