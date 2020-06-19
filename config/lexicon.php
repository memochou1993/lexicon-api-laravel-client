<?php

use MemoChou1993\Lexicon\Http\Middleware\Authorize;

return [

    'host' => env('LEXICON_HOST'),

    'project_id' => env('LEXICON_PROJECT_ID'),

    'api_key' => env('LEXICON_API_KEY'),

    'path' => 'lexicon',

    'middleware' => [
        Authorize::class,
    ],

    'filename' => 'lexicon',

];
