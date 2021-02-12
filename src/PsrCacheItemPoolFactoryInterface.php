<?php
namespace Germania\NamespacedCache;


interface PsrCacheItemPoolFactoryInterface
{

    /**
     * Creates a namespaced PSR CacheItemPool.
     *
     * @param  string $namespace Namespace name
     * @return \Psr\Cache\CacheItemPoolInterface
     */
    public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface;
}
