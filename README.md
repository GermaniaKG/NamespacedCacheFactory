<img src="https://static.germania-kg.com/logos/ga-logo-2016-web.svgz" width="250px">

------


# Namespaced CacheItemPool Factory



## Installation

```bash
$ composer require germania-kg/namespaced-cache
```

One of these libraries is required to be installed manually:

- [Stash PHP cache](http://www.stashphp.com)
- [Symfony Cache Component](https://symfony.com/components/Cache)

```bash
$ composer require symfony/cache
$ composer require tedivm/stash
```



## Interfaces

### Factory Interface

Classes implementing the **PsrCacheItemPoolFactoryInterface** are callable. Their invokation method accepts a *namespace string*.

```php
<?php
Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;

interface PsrCacheItemPoolFactoryInterface
{
    public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface;
}
```

### DefaultLifeTimeAware

Define a default lifetime for cache items. It can be used on those PSR-6 libraries that support default life times on cache item pools.

```php
<?php
use Germania\NamespacedCache\DefaultLifeTimeAware;

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

```

**Example:**

```php
<?php
use Germania\NamespacedCache\SymfonyFileCacheItemPoolFactory;
use Germania\NamespacedCache\DefaultLifeTimeAware;

$factory = new SymfonyFileCacheItemPoolFactory($directory);
if ($factory instanceOf DefaultLifeTimeAware::class) {
    $factory->setDefaultLifetime( 3600 );
}
```



## Filesystem caches

### Symfony Cache Component

Callable class **SymfonyFileCacheItemPoolFactory** extends *SymfonyCacheItemPoolFactory* and implements *PsrCacheItemPoolFactoryInterface* and *DefaultLifeTimeAware*:

```php
<?php
use Germania\NamespacedCache\SymfonyFileCacheItemPoolFactory;

# These are defaults
$directory = getcwd(); 
$default_lifetime = 0;

$factory = new SymfonyFileCacheItemPoolFactory();
$factory = new SymfonyFileCacheItemPoolFactory($directory, $default_lifetime);
$factory = (new SymfonyFileCacheItemPoolFactory($directory))
           ->setDefaultLifetime( 3600 );

// Psr\Cache\CacheItemPoolInterface
$cache = $factory("my_namespace");
```

### Stash PHP Caching Library

Callable class **StashFileCacheItemPoolFactory** implements *PsrCacheItemPoolFactoryInterface*. Note that Stash caches do not provide setting default cache item lifetime.

```php
<?php
use Germania\NamespacedCache\StashFileCacheItemPoolFactory;

# These are defaults
$directory = getcwd(); 

$factory = new StashFileCacheItemPoolFactory();
$factory = new StashFileCacheItemPoolFactory($directory);
  
// Psr\Cache\CacheItemPoolInterface
$cache = $factory("my_namespace");
```

## Sqlite Caches

### Symfony Cache Component

Callable class **SymfonySqliteCacheItemPoolFactory** extends *SymfonyCacheItemPoolFactory* and implements *PsrCacheItemPoolFactoryInterface* and *DefaultLifeTimeAware*.

```php
<?php
use Germania\NamespacedCache\SymfonySqliteCacheItemPoolFactory;

# These are defaults
$pdo_dsn = "sqlite::memory:"; 
$default_lifetime = 0;

$factory = new SymfonySqliteCacheItemPoolFactory();
$factory = new SymfonySqliteCacheItemPoolFactory($pdo_dsn, $default_lifetime);
$factory = (new SymfonySqliteCacheItemPoolFactory($pdo_dsn))
           ->setDefaultLifetime( 3600 );

// Psr\Cache\CacheItemPoolInterface
$cache = $factory("my_namespace");
```



### Stash PHP Caching Library

Callable class **StashSqliteCacheItemPoolFactory** implements *PsrCacheItemPoolFactoryInterface*.

Note that Stash caches do not provide setting default cache item lifetime.

```php
<?php
use Germania\NamespacedCache\StashSqliteCacheItemPoolFactory;

# These are defaults
$directory = getcwd(); 

$factory = new StashSqliteCacheItemPoolFactory();
$factory = new StashSqliteCacheItemPoolFactory($directory);
  
// Psr\Cache\CacheItemPoolInterface
$cache = $factory("my_namespace");
```



## Testing

```bash
$ composer phpunit
```

