<?php

namespace MemoChou\Localize\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \MemoChou\Localize\Localize getLanguages()
 * @method static \MemoChou\Localize\Localize hasLanguage(string $language)
 * @method static \MemoChou\Localize\Localize only(array|string ...$languages)
 * @method static \MemoChou\Localize\Localize except(array|string ...$languages)
 * @method static \MemoChou\Localize\Localize export(array|string ...$languages)
 * @method static \MemoChou\Localize\Localize clear()
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
