<?php
namespace Germania\NamespacedCache;

trait DefaultLifeTimeTrait
{


    /**
     * @var int|null
     */
    protected $default_lifetime;


    /**
     * Returns default cache item lifetime.
     *
     * @return int|null
     */
    public function getDefaultLifetime() : ?int
    {
        return $this->default_lifetime;
    }


    /**
     * Sets default cache item lifetime.
     *
     * @param int|null $lifetime Default cache item lifetime
     */
    public function setDefaultLifetime( ?int $lifetime) : static
    {
        $this->default_lifetime = $lifetime;
        return $this;
    }
}
