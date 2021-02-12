<?php
namespace Germania\NamespacedCache;

class StashFileCacheItemPoolFactory implements PsrCacheItemPoolFactoryInterface {


    /**
     * @var ?string
     */
    public $directory = null;

    /**
     * @var int
     */
    public $default_lifetime = 0;


    /**
     * Accepts two optional parameters:
     *
     * - Main cache directory (the application needs read-write permissions on it)
     *   If none is specified, a directory is created inside the system temporary directory
     * - Default cache lifetime in seconds; applied to cache items that don't define their own lifetime
     *   0 means to store the cache items indefinitely (i.e. until the files are deleted)
     *
     * @param ?string  $directory         Main cache directory, defaults to current work dir.
     * @param int      $default_lifetime  Default cache lifetime
     */
    public function __construct( string $directory = null, int $default_lifetime = 0)
    {
        $this->directory = $directory ?: getcwd();
        $this->default_lifetime = $default_lifetime;
    }


    /**
     * @param  string $namespace Subdirectory of the main cache directory where cache items are stored
     * @return \Psr\Cache\CacheItemPoolInterface
     *
     * @see  https://symfony.com/doc/current/components/cache/adapters/filesystem_adapter.html
     * @see  https://github.com/symfony/symfony/blob/5.x/src/Symfony/Component/Cache/Adapter/AbstractAdapter.php
     */
    public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface
    {
        $driver = $this->createCacheDriver();
        $pool = $this->createItemPool($driver);
        $pool->setNamespace($namespace);
        return $pool;
    }


    protected function createItemPool( \Stash\Driver\AbstractDriver $driver ) : \Stash\Pool
    {
        $pool = new \Stash\Pool($driver);
        return $pool;
    }


    protected function createCacheDriver() : \Stash\Driver\AbstractDriver
    {
        $driver = new \Stash\Driver\FileSystem([
            'path' => $this->directory
        ]);
        return $driver;
    }
}
