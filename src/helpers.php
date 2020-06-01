<?php

if (! function_exists('localize')) {
    /**
     * Translates the given message based on a count.
     *
     * @param  string|null  $key
     * @param  \Countable|int|array  $number
     * @param  array  $replace
     * @param  string|null  $locale
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    function localize($key = null, $number = 0, array $replace = [], $locale = null)
    {
        if (is_null($key)) {
            return app('translator');
        }

        $key = sprintf('%s.%s', config('localize.filename'), $key);

        return app('translator')->choice($key, $number, $replace, $locale);
    }
}

if (! function_exists('___')) {
    /**
     * Translates the given message based on a count.
     *
     * @param  string|null  $key
     * @param  \Countable|int|array  $number
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string|null
     */
    function ___($key = null, $number = 0, array $replace = [], $locale = null)
    {
        if (is_null($key)) {
            return $key;
        }

        return localize($key, $number, $replace, $locale);
    }
}
