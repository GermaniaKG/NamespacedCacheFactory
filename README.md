<img src="https://static.germania-kg.com/logos/ga-logo-2016-web.svgz" width="250px">

------


# Namespaced CacheItemPool Factory



## Installation

```bash
$ composer require germania-kg/namespaced-cache
$ composer require symfony/cache
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

**Symfony Cache in Filesystem**

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



**Symfony Cache with Sqlite**

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



## Testing

Copy `phpunit.xml.dist` to `phpunit.xml` and run **PhpUnit:**

```bash
$ composer phpunit
```

