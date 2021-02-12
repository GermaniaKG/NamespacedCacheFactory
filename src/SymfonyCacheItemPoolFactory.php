<?php
namespace Germania\NamespacedCache;

abstract class SymfonyCacheItemPoolFactory implements PsrCacheItemPoolFactoryInterface, DefaultLifeTimeAware
{
    use DefaultLifeTimeTrait;


    /**
     * @inheritDoc
     */
    abstract public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface;
}
