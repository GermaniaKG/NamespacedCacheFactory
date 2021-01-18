<?php
namespace Germania\NamespacedCache;

use Symfony\Component\Cache\Adapter\PdoAdapter;
use Psr\Cache\CacheItemPoolInterface;

class SymfonySqliteCacheItemPoolFactory implements PsrCacheItemPoolFactoryInterface {


    /**
     * @var string|\PDO
     */
    public $pdo_dsn = null;


    /**
     * @var mixed[]
     */
    public $adapter_options = array();


    /**
     * @var int
     */
    public $default_lifetime = 0;


    /**
     * @param string $pdo_dsn           PDO instance, a Doctrine DBAL connection or DSN
     * @param int    $default_lifetime  Default cache lifetime
     */
    public function __construct( string $pdo_dsn = "sqlite::memory:", int $default_lifetime = 0)
    {
        $this->pdo_dsn = $pdo_dsn;
        $this->default_lifetime = $default_lifetime;
    }


    /**
     * @param  string $namespace Cache namespace
     * @return \Psr\Cache\CacheItemPoolInterface
     *
     * @see  https://symfony.com/doc/current/components/cache/adapters/pdo_doctrine_dbal_adapter.html
     * @see  https://github.com/symfony/symfony/blob/5.x/src/Symfony/Component/Cache/Adapter/AbstractAdapter.php
     */
    public function __invoke( string $namespace) : \Psr\Cache\CacheItemPoolInterface
    {
        return new PdoAdapter( $this->pdo_dsn, $namespace, $this->default_lifetime, $this->adapter_options );
    }
}
