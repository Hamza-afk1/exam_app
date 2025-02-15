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
            'provider' => 'admins',
        ],
        'formateur' => [
            'driver' => 'session',
            'provider' => 'formateurs',
        ],
        'stagiaire' => [
            'driver' => 'session',
            'provider' => 'stagiaires',
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'formateurs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Formateur::class,
        ],
        'stagiaires' => [
            'driver' => 'eloquent',
            'model' => App\Models\Stagiaire::class,
        ],
    ],
];