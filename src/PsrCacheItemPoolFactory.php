<?php
namespace Germania\NamespacedCache;


abstract class PsrCacheItemPoolFactory
{

    /**
     * @param  string      $dsn_or_path      Sqlite DSN or filesystem path
     * @param  int|integer $default_lifetime Default cache lifetime in seconds
     *
     * @return PsrCacheItemPoolFactoryInterface
     */
    public static function autodiscover(string $dsn_or_path, int $default_lifetime = 0 ) : PsrCacheItemPoolFactoryInterface
    {
        if (extension_loaded('SQLite3')) {
            return new SqliteCacheItemPoolFactory($dsn_or_path, $default_lifetime);
        }
        return new FileCacheItemPoolFactory($dsn_or_path, $default_lifetime);
    }
}
