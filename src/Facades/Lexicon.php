<?php

namespace MemoChou1993\Lexicon\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection getLanguages()
 * @method static bool hasLanguage(string $language)
 * @method static \MemoChou1993\Lexicon\Lexicon only(array|string ...$languages)
 * @method static \MemoChou1993\Lexicon\Lexicon except(array|string ...$languages)
 * @method static void export(array|string ...$languages)
 * @method static \MemoChou1993\Lexicon\Lexicon clear()
 * @method static string trans($key = null, $number = 0, array $replace = [], $locale = null)
 *
 * @see \MemoChou1993\Lexicon\Lexicon
 */
class Lexicon extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lexicon';
    }
}
