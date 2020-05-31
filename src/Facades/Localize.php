<?php

// TODO: rename to MemoChou1993
namespace MemoChou\Localize\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection getLanguages()
 * @method static bool hasLanguage(string $language)
 * @method static \MemoChou\Localize\Localize only(array|string ...$languages)
 * @method static \MemoChou\Localize\Localize except(array|string ...$languages)
 * @method static void export(array|string ...$languages)
 * @method static \MemoChou\Localize\Localize flush()
 *
 * @see \MemoChou\Localize\Localize
 */
class Localize extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'localize';
    }
}
