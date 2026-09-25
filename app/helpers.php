<?php

use Illuminate\Contracts\Support\Arrayable;

if (! function_exists('lroute')) {
    /**
     * Generate a URL for a named site route, automatically prefixed with the
     * current locale (routes/web.php registers every route twice: once under
     * "tr." and once under "en.").
     */
    function lroute(string $name, array|Arrayable $parameters = [], bool $absolute = true): string
    {
        return route(app()->getLocale().'.'.$name, $parameters, $absolute);
    }
}
