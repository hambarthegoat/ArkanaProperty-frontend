<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | ArkanaProperty Backend
    |--------------------------------------------------------------------------
    |
    | Base URL of the backend REST API (called server-side with the Sanctum
    | token stored in the session) and the backend's Filament admin panel.
    |
    */

    'arkana_api' => [
        'url' => env('ARKANA_API_URL', 'http://127.0.0.1:8000/api'),
        'timeout' => (int) env('ARKANA_API_TIMEOUT', 10),
        'admin_panel_url' => env('ARKANA_ADMIN_PANEL_URL', 'http://127.0.0.1:8000/admin'),
    ],

];
