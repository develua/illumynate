<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class CacheFile
{
    const CACHE_FOLDER = '../cache/';

    public static function saveContent($provider, $content)
    {
        return file_put_contents(self::getPathFile($provider), $content);
    }

    public static function getContent($provider)
    {
        return file_get_contents(self::getPathFile($provider));
    }

    public static function issetContent($provider)
    {
        return file_exists(self::getPathFile($provider));
    }

    public static function deleteCache($provider)
    {
        unlink(self::getPathFile($provider));
    }

    private static function getPathFile($provider)
    {
        return self::CACHE_FOLDER . md5($provider . ':' . Auth::user()->id);
    }

    public static function tremSpace($content)
    {
        return preg_replace("/\s{2,}/", '', $content);
    }
}
