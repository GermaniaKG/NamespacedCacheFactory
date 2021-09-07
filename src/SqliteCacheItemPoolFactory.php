<?php
namespace Germania\NamespacedCache;

use Germania\NamespacedCache\Exceptions;
use Stash\Driver\Sqlite as StashSqlite;
use Symfony\Component\Cache\Adapter\PdoAdapter as SymfonySqlite;

class SqliteCacheItemPoolFactory implements PsrCacheItemPoolFactoryInterface
{

    /**
     * Force cache engine, values one of `auto`, `symfony`, or `stash`
     * @var string
     */
    public static $cache_engine = "auto";

    /**
     * @var \Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface
     */
    protected $factory;


    /**
     * @param string $dsn_or_directory       Sqlite path or DSN
     * @param int    $default_lifetime  Default cache lifetime, defaults to `0` (infinity)
     *
     * @throws RuntimeException         when neither Stash or Symfony Cache is installed.
     */
    public function __construct(  string $dsn_or_directory, int $default_lifetime = 0)
    {
        if (static::$cache_engine == "symfony"
        or (static::$cache_engine == "auto" and class_exists(SymfonySqlite::class))) {
            $factory = new SymfonySqliteCacheItemPoolFactory($dsn_or_directory, $default_lifetime);
        }
        elseif (static::$cache_engine == "stash"
        or (static::$cache_engine == "auto" and class_exists(StashSqlite::class))) {
            $factory = new StashSqliteCacheItemPoolFactory($dsn_or_directory);
        }
        else {
            throw new \RuntimeException("Missing cache library, either Stash or Symfony Cache required.");
        }

        $this->setCacheItemPoolFactory($factory);
    }

    /**
     * @inheritDoc
     */
    public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface
    {
        return ($this->factory)($namespace);
    }



    /**
     * @param \Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface
     */
    public function setCacheItemPoolFactory( PsrCacheItemPoolFactoryInterface $factory )
    {
        $this->factory = $factory;
        return $this;
    }


}
