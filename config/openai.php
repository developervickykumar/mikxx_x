<?php

return [
    'api_key' => env('OPENAI_API_KEY'), // moved to .env
    'organization' => env('OPENAI_ORGANIZATION'), // Optional
    'base_uri' => env('OPENAI_BASE_URI', 'https://api.openai.com/v1'),
    'http_client_handler' => null,
];
