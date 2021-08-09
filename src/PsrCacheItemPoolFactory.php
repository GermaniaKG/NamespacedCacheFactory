<?php
namespace Germania\NamespacedCache;


abstract class PsrCacheItemPoolFactory
{

    public static function autodiscover(   string $path, int $default_lifetime = 0 ) : PsrCacheItemPoolFactoryInterface
    {
        if (extension_loaded('sqlite3')) {
            return new SqliteCacheItemPoolFactory($path, $default_lifetime);
        }
        return new FileCacheItemPoolFactory($path, $default_lifetime);
    }
}
