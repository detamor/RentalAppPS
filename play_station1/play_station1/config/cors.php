<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:8080'], // Ganti dengan URL frontend Vue
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];