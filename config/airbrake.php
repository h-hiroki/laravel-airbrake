<?php

return [
    // Globally enable airbrake
    'enabled' => env('AIRBRAKE_ENABLED', false),

    // Environments to ignore errors
    'ignore_environments' => [
        'local',
        'testing',
        'development'
    ],

    // API Key
    'id'  => env('AIRBRAKE_PROJECT_ID', ''),
    'key' => env('AIRBRAKE_API_KEY', ''),

    // Connection to the airbrake server
    'host'      => 'api.airbrake.io',
];
