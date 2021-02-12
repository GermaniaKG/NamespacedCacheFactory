<?php
namespace Germania\NamespacedCache;

use Stash\Driver\FileSystem as StashFileSystem;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as SymfonyFileSystem;

class FileCacheItemPoolFactory implements PsrCacheItemPoolFactoryInterface
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
     * @param ?string  $directory       Main cache directory, defaults to current work dir.
     * @param int    $default_lifetime  Default cache lifetime, defaults to `0` (infinity)
     *
     * @throws RuntimeException         when neither Stash or Symfony Cache is installed.
     */
    public function __construct( string $directory = null, int $default_lifetime = 0)
    {
        if (static::$cache_engine == "symfony"
        or (static::$cache_engine == "auto" and class_exists(SymfonyFileSystem::class))) {
            $factory = new SymfonyFileCacheItemPoolFactory($directory, $default_lifetime);
        }
        elseif (static::$cache_engine == "stash"
        or (static::$cache_engine == "auto" and class_exists(StashFileSystem::class))) {
            $factory = new StashFileCacheItemPoolFactory($directory);
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
}
