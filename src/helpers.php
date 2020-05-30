<?php

if (! function_exists('localize')) {
    /**
     * Translates the given message based on a count.
     *
     * @param  string  $key
     * @param  \Countable|int|array  $number
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string
     */
    function localize($key, $number = 0, array $replace = [], $locale = null)
    {
        return app('translator')->choice('localize.'.$key, $number, $replace, $locale);
    }
}

if (! function_exists('___')) {
    /**
     * Translates the given message based on a count.
     *
     * @param  string  $key
     * @param  \Countable|int|array  $number
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string
     */
    function ___($key, $number = 0, array $replace = [], $locale = null)
    {
        return localize($key, $number, $replace, $locale);
    }
}
