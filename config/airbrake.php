<?php

return [
    
    // Globally enable airbrake
    'enabled' => env('AIRBRAKE_ENABLED', false),

    // API Key
    'id'  => env('AIRBRAKE_PROJECT_ID', ''),
    'key' => env('AIRBRAKE_API_KEY', ''),

    // Connection to the airbrake server
    'host'      => 'api.airbrake.io',
];
