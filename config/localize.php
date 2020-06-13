<?php

use MemoChou1993\Localize\Http\Middleware\Authorize;

return [

    'host' => env('LOCALIZE_HOST'),

    'project_id' => env('LOCALIZE_PROJECT_ID'),

    'api_key' => env('LOCALIZE_API_KEY'),

    'path' => 'localize',

    'middleware' => [
        Authorize::class,
    ],

    'filename' => 'localize',

];
