<?php
return [
    'paths' => [
        'api/*',
        'broadcasting/auth',
        'storage/*',          // ← Add this
        'songs/*',            // ← If needed
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:8081',
        'http://localhost:*',     // wildcard for dev ports
        'https://born-quarters-flour-aspects.trycloudflare.com',
        'https://fatidic-elin-unelective.ngrok-free.dev'
    ],

    'allowed_origins_patterns' => [
        '/^https:\/\/.*\.trycloudflare\.com$/',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,  // Change to false unless you really need cookies/auth
];