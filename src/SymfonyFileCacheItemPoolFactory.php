<?php
namespace Germania\NamespacedCache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter ;

class SymfonyFileCacheItemPoolFactory extends SymfonyCacheItemPoolFactory {

    use FilesystemTrait;


    /**
     * @param ?string  $directory       Main cache directory, defaults to current work dir.
     * @param int    $default_lifetime  Default cache lifetime, defaults to `0` (infinity)
     */
    public function __construct( string $directory = null, int $default_lifetime = 0)
    {
        $this->setPath($directory ?: getcwd());
        $this->setDefaultLifetime($default_lifetime);
    }


    /**
     * @param  string $namespace Subdirectory of the main cache directory where cache items are stored
     * @return \Psr\Cache\CacheItemPoolInterface
     *
     * @see  https://symfony.com/doc/current/components/cache/adapters/filesystem_adapter.html
     * @see  https://github.com/symfony/symfony/blob/5.x/src/Symfony/Component/Cache/Adapter/AbstractAdapter.php
     */
    public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface
    {
        $default_lifetime = $this->getDefaultLifetime();
        $path = $this->getPath();

        return new FilesystemAdapter( $namespace, $default_lifetime, $path );
    }
}
