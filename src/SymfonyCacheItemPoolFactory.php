<?php
namespace Germania\NamespacedCache;

abstract class SymfonyCacheItemPoolFactory
{
    use DefaultLifeTimeTrait;


    /**
     * @inheritDoc
     */
    abstract public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface;
}
