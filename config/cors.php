<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    // Lock CORS to an explicit allow-list. Set CORS_ALLOWED_ORIGINS in .env as a
    // comma-separated list of trusted front-end / mobile origins, e.g.
    // CORS_ALLOWED_ORIGINS=https://app.example.com,https://admin.example.com
    'allowed_origins' => array_filter(
        explode(',', env('CORS_ALLOWED_ORIGINS', env('APP_URL', '')))
    ),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Accept', 'Authorization', 'Content-Type', 'X-Requested-With', 'X-CSRF-TOKEN', 'X-XSRF-TOKEN'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
