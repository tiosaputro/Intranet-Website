<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', ''),
        'host'           => env('DB_HOST', 'localhost'),
        'port'           => env('DB_PORT', '1521'),
        'port'           => '1521',
        // 'database'       => env('DB_DATABASE', ''),
        'database'       => 'Intranet-local',
        // 'username'       => env('DB_USERNAME', ''),
        'username'       => 'intranet',
        // 'password'       => env('DB_PASSWORD', ''),
        'password'       => 'intranet',
        'service_name'       => 'xe',
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];
