<?php
    return [
        'defaults' => [
            'guard'     => 'api',
            'passwords' => 'users',
        ],
        'guards' => [
            'passport' => [
                'driver'   => 'passport',
                'provider' => 'users',
            ],
            'api' => [
                'driver'   => 'jwt',
                'provider' => 'users',
            ],
        ],
        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model'  => \App\Models\User::class
            ]
        ]
    ];