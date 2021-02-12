<?php
namespace Germania\NamespacedCache;

abstract class StashCacheItemPoolFactory implements PsrCacheItemPoolFactoryInterface
{


    /**
     * Creates a Stash Cache Pool.
     *
     * @param  \Stash\Driver\AbstractDriver $driver Stash cache driver
     * @return \Stash\Pool
     */
    protected function createItemPool( \Stash\Driver\AbstractDriver $driver ) : \Stash\Pool
    {
        $pool = new \Stash\Pool($driver);
        return $pool;
    }



    /**
     * @inheritDoc
     */
    public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface
    {
        $driver = $this->createCacheDriver();
        $pool = $this->createItemPool($driver);
        $pool->setNamespace($namespace);
        return $pool;
    }


    /**
     * Creates a Stash Driver.
     *
     * @return \Stash\Driver\AbstractDriver
     */
    abstract protected function createCacheDriver() : \Stash\Driver\AbstractDriver;
}
