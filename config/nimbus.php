<?php

// config for hjbdev/Nimbus
return [
    'database' => [
        'connection' => null,
        'tables' => [
            'exceptions' => 'nimbus_exceptions',
            'trace_lines' => 'nimbus_trace_lines',
        ],
    ],

    'enabled' => env('NIMBUS_ENABLED', true),

    'route' => [
        'prefix' => 'nimbus',
        'middleware' => ['web'],
    ],
];
