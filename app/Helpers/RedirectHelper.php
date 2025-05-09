<?php

namespace App\Helpers;

class RedirectHelper
{
    public static function validate($url)
    {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '/';

        if (preg_match('#^/rooms(/[\w-]+)?$#', $path)) {
            return $path;
        }

        return '/';
    }
}
