<img src="https://static.germania-kg.com/logos/ga-logo-2016-web.svgz" width="250px">

------


# Namespaced CacheItemPool Factory



## Installation

```bash
$ composer require germania-kg/namespaced-cache

# One of these is required:
$ composer require symfony/cache
$ composer require tedivm/stash
```



## Factory Interface

Classes implementing the **PsrCacheItemPoolFactoryInterface** are callable. Their invokation method accepts a *namespace string*.

```php
<?php
Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;

interface PsrCacheItemPoolFactoryInterface
{
    public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface;
}
```



## Factory classes

### Caches in Filesystem

#### Symfony Cache Component

Callable class **SymfonyFileCacheItemPoolFactory** implements *PsrCacheItemPoolFactoryInterface:*

```php
<?php
use Germania\NamespacedCache\SymfonyFileCacheItemPoolFactory;

# These are defaults
$directory = getcwd(); 
$default_lifetime = 0;

$factory = new SymfonyFileCacheItemPoolFactory();
$factory = new SymfonyFileCacheItemPoolFactory($directory, $default_lifetime);
  
// Psr\Cache\CacheItemPoolInterface
$cache = $factory("my_namespace");
```

#### Stash PHP Caching Library

Callable class **StashFileCacheItemPoolFactory** implements *PsrCacheItemPoolFactoryInterface:*

```php
<?php
use Germania\NamespacedCache\StashFileCacheItemPoolFactory;

# These are defaults
$directory = getcwd(); 
$default_lifetime = 0;

$factory = new StashFileCacheItemPoolFactory();
$factory = new StashFileCacheItemPoolFactory($directory, $default_lifetime);
  
// Psr\Cache\CacheItemPoolInterface
$cache = $factory("my_namespace");
```

### Caches using Sqlite

#### Symfony Cache Component

Callable class **SymfonySqliteCacheItemPoolFactory** implements *PsrCacheItemPoolFactoryInterface:*

```php
<?php
use Germania\NamespacedCache\SymfonySqliteCacheItemPoolFactory;

# These are defaults
$pdo_dsn = "sqlite::memory:"; 
$default_lifetime = 0;

$factory = new SymfonySqliteCacheItemPoolFactory();
$factory = new SymfonySqliteCacheItemPoolFactory($pdo_dsn, $default_lifetime);
  
// Psr\Cache\CacheItemPoolInterface
$cache = $factory("my_namespace");
```



#### Stash PHP Caching Library

Callable class **StashSqliteCacheItemPoolFactory** implements *PsrCacheItemPoolFactoryInterface:*

```php
<?php
use Germania\NamespacedCache\StashSqliteCacheItemPoolFactory;

# These are defaults
$directory = getcwd(); 
$default_lifetime = 0;

$factory = new StashSqliteCacheItemPoolFactory();
$factory = new StashSqliteCacheItemPoolFactory($directory, $default_lifetime);
  
// Psr\Cache\CacheItemPoolInterface
$cache = $factory("my_namespace");
```



## Testing

```bash
$ composer phpunit
```

