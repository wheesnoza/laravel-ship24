<?php

return [
    'access_token' => env('SHIP24_ACCESS_TOKEN'),
    'uri' => env('SHIP24_URI', 'https://api.ship24.com'),
    'rate_limit' => [
        'enabled' => env('SHIP24_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SHIP24_RATE_LIMIT_MAX_ATTEMPTS', 3),
        'base_delay_seconds' => env('SHIP24_RATE_LIMIT_BASE_DELAY_SECONDS', 2),
        'max_delay_seconds' => env('SHIP24_RATE_LIMIT_MAX_DELAY_SECONDS', 60),
    ],
    'cache' => [
        'enabled' => env('SHIP24_CACHE_ENABLED', false),
        'ttl_seconds' => env('SHIP24_CACHE_TTL_SECONDS', 300),
        'store' => env('SHIP24_CACHE_STORE'),
        'prefix' => env('SHIP24_CACHE_PREFIX', 'ship24'),
    ],
];
