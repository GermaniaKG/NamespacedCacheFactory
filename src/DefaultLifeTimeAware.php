<?php
namespace Germania\NamespacedCache;

interface DefaultLifeTimeAware
{
    /**
     * Returns default cache item lifetime.
     *
     * @return int|null
     */
    public function getDefaultLifetime() : ?int;


    /**
     * Sets default cache item lifetime.
     *
     * @param int|null $lifetime Default cache item lifetime
     */
    public function setDefaultLifetime( ?int $lifetime) : static;
}
