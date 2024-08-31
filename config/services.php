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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'telegram' => [
        'bot' => env('TELEGRAM_BOT_NAME'),  // The bot's username
        'client_id' => null,
        'client_secret' => env('TELEGRAM_TOKEN'),
        'redirect' => env('TELEGRAM_REDIRECT_URI'),
    ],

    'google' => [    
        'client_id' => env('GOOGLE_CLIENT_ID'),  
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),  
        'redirect' => env('GOOGLE_REDIRECT_URI') 
    ],

    'yandex' => [    
        'client_id' => env('YANDEX_CLIENT_ID'),  
        'client_secret' => env('YANDEX_CLIENT_SECRET'),  
        'redirect' => env('YANDEX_REDIRECT_URI') 
    ],

    'vkontakte' => [    
      'client_id' => env('VKONTAKTE_CLIENT_ID'),  
      'client_secret' => env('VKONTAKTE_CLIENT_SECRET'),  
      'redirect' => env('VKONTAKTE_REDIRECT_URI') 
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
