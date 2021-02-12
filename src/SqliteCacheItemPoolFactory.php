<?php
namespace Germania\NamespacedCache;

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
     * @param string $dsn_or_path     Sqlite path or DSN, defaults to current work dir.
     * @param int    $default_lifetime  Default cache lifetime, defaults to `0` (infinity)
     *
     * @throws RuntimeException         when neither Stash or Symfony Cache is installed.
     */
    public function __construct(  string $dsn_or_path, int $default_lifetime = 0)
    {
        if (static::$cache_engine == "symfony"
        or (static::$cache_engine == "auto" and class_exists(SymfonySqlite::class))) {
            if (!$this->isSqliteDsnString($dsn_or_path)) {
                throw new \UnexpectedValueException("Symfony Cache requires a SQlite DSN string");
            }
            $factory = new SymfonySqliteCacheItemPoolFactory($dsn_or_path, $default_lifetime);
        }
        elseif (static::$cache_engine == "stash"
        or (static::$cache_engine == "auto" and class_exists(StashSqlite::class))) {

            if ($this->isSqliteDsnString($dsn_or_path)) {
                throw new \UnexpectedValueException("Stash Cache requires a directory path to store the sqlite file");
            }
            $factory = new StashSqliteCacheItemPoolFactory($dsn_or_path);
        }
        else {
            throw new \RuntimeException("Either Stash or Symfony Cache required.");
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
    public function setCacheItemPoolFactory( PsrCacheItemPoolFactoryInterface $factory ) : static
    {
        $this->factory = $factory;
        return $this;
    }

    protected function isSqliteDsnString( string $dsn_or_path) : bool
    {
        $len = strlen("sqlite:");
        return (substr(strtolower($dsn_or_path), 0, $len) === "sqlite:");
    }


}
