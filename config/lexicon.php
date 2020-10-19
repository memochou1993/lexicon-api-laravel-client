<?php

return [

    'host' => env('LEXICON_HOST'),

    'api_key' => env('LEXICON_API_KEY'),

    'path' => 'lexicon',

    'middleware' => [
        \MemoChou1993\Lexicon\Http\Middleware\Authorize::class,
    ],

    'filename' => 'lexicon',

];
