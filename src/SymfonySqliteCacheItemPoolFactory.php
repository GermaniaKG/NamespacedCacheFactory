<?php
namespace Germania\NamespacedCache;

use Symfony\Component\Cache\Adapter\PdoAdapter;
use Psr\Cache\CacheItemPoolInterface;

class SymfonySqliteCacheItemPoolFactory extends SymfonyCacheItemPoolFactory {

    /**
     * @var string|\PDO
     */
    public $pdo_dsn = null;


    /**
     * @var mixed[]
     */
    public $adapter_options = array();


    /**
     * @param string $dsn_or_directory  PDO instance, a Doctrine DBAL connection or DSN
     * @param int    $default_lifetime  Default cache lifetime, defaults to `0` (infinity)
     */
    public function __construct( string $dsn_or_directory = "sqlite::memory:", int $default_lifetime = 0)
    {
        if (!$this->isSqliteDsnString($dsn_or_directory)) {
            $dsn_or_directory = $this->convertDirectoryToSqliteDsn($dsn_or_directory);
        }
        $this->pdo_dsn = $dsn_or_directory;
        $this->setDefaultLifetime($default_lifetime);
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
        $default_lifetime = $this->getDefaultLifetime();
        return new PdoAdapter( $this->pdo_dsn, $namespace, $default_lifetime, $this->adapter_options );
    }



    /**
     * Check if a string is a SQlite DSN, i.e. if it begins with "sqlite:"
     *
     * @param  string  $directory
     * @return boolean
     */
    protected function isSqliteDsnString( string $directory) : bool
    {
        $len = strlen("sqlite:");
        return (substr(strtolower($directory), 0, $len) === "sqlite:");
    }


    protected function convertDirectoryToSqliteDsn( string $directory ) : string
    {
        if (!is_dir($directory)) {
            $msg = sprintf("Not a directory: '%s'", $directory);
            throw new \RuntimeException($msg);
        }

        $tpl = "sqlite:%s/cache.sqlite";
        return sprintf($tpl, $directory);
    }
}
