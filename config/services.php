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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'authentik' => [
        'base_url' => env('AK_BASE_URL'),
        'client_id' => env('AK_CLIENT_ID'),
        'client_secret' => env('AK_CLIENT_SECRET'),
        'redirect' => env('AK_REDIRECT_URI'),
    ],
];
