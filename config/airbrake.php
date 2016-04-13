<?php

return [
    
    // Globally enable airbrake
    'enabled' => env('AIRBRAKE_ENABLED', false),

    // API Key
    'api_key' => env('AIRBRAKE_API_KEY', ''),
    //'id'  => '',

    //'key' => '',

    // Connection to the airbrake server
    'host'      => 'api.airbrake.io',
];
