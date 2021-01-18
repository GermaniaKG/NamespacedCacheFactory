<?php
namespace Germania\NamespacedCache;


interface PsrCacheItemPoolFactoryInterface
{
    public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface;
}
