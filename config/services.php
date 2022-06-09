<?php

return [
    'passport' => [
		'login_endpoint' => env('PASSPORT_LOGIN_ENDPOINT'),
		'client_id'      => env('PASSPORT_CLIENT_ID'),
		'client_secret'  => env('PASSPORT_CLIENT_SECRET'),
    ],
    
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT')
    ],
];
