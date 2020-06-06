<?php

use MemoChou1993\Localize\Http\Middleware\Authorize;

return [

    'api_url' => env('LOCALIZE_API_URL'),

    'api_key' => env('LOCALIZE_API_KEY'),

    'path' => 'api/localize',

    'middleware' => [
        Authorize::class,
    ],

    'filename' => 'localize',

];
