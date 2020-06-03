<?php

return [
    // Globally enable airbrake
    'enabled' => env('AIRBRAKE_ENABLED', false),

    // Environments to ignore errors
    'ignore_environments' => [
        'local',
        'testing',
        'development',
    ],

    // Exceptions to ignore errors
    'ignore_exceptions' => [],

    // API Key
    'id'  => env('AIRBRAKE_PROJECT_ID', ''),
    'key' => env('AIRBRAKE_API_KEY', ''),

    // Connection to the airbrake server
    'host' => env('AIRBRAKE_API_HOST', 'api.airbrake.io'),

    // API Key for each Exception
    // If you set this config, notifier notifys exceptions based on this config instead.
    'exception_rooting' => [
        'App\Exception\SomeException' => [
            'host' => env('AIRBRAKE_API_HOST_SOME_EXCEPTION', 'api.airbrake.io'),
            'id' => env('AIRBRAKE_PROJECT_ID_SOME_EXCEPTION', ''),
            'key' => env('AIRBRAKE_API_KEY_SOME_EXCEPTION', '')
        ]
    ]
];
