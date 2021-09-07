<?php
namespace tests;

use Stash\Pool as StashPool;
use Symfony\Component\Cache\Adapter\PdoAdapter as SymfonySqlitePdo;
use Germania\NamespacedCache\SqliteCacheItemPoolFactory;
use Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;

class SqliteCacheItemPoolFactoryTest extends \PHPUnit\Framework\TestCase
{


    public function testInstantiation() : SqliteCacheItemPoolFactory
    {
        $dsn_or_path = sys_get_temp_dir();
        $sut = new SqliteCacheItemPoolFactory($dsn_or_path);
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        $dsn_or_path = "sqlite::memory:";
        $sut = new SqliteCacheItemPoolFactory($dsn_or_path);
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     * @todo Remove suppress errors '@' operator when Stash has upgraded their method signatures.
     */
    public function testFactoryMethod(SqliteCacheItemPoolFactory $sut) : void
    {
        $result = @$sut("namespace");
        $this->assertInstanceOf(CacheItemPoolInterface::class, $result);
    }




    /**
     * @dataProvider provideCacheFactoryKeywords
     * @todo Remove suppress errors '@' operator when Stash has upgraded their method signatures.
     */
    public function testForceFactoryMethod(string $keyword, string $dsn_or_path) : void
    {

        SqliteCacheItemPoolFactory::$cache_engine = $keyword;

        $sut = new SqliteCacheItemPoolFactory($dsn_or_path);
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        if ($keyword == "stash")
            $result = @$sut("namespace");
        else {
            $result = $sut("namespace");
        }

        $this->assertInstanceOf(CacheItemPoolInterface::class, $result);

        switch($keyword):
            case "stash":
                $this->assertInstanceOf(StashPool::class, $result);
                break;
            case "symfony":
                $this->assertInstanceOf(SymfonySqlitePdo::class, $result);
                break;
            default:
                break;
        endswitch;

        $key   = "foo";
        $value = bin2hex(random_bytes(20));

        $item = $result->getItem($key);
        $this->assertInstanceOf(CacheItemInterface::class, $item);

        $item->set($value);
        $item->expiresAfter(60);
        $result->save($item);

        $item = $result->getItem($key);
        $this->assertInstanceOf(CacheItemInterface::class, $item);
        $this->assertEquals($item->get(), $value);
    }


    public function provideCacheFactoryKeywords() : array
    {
        $tmp_dir = sys_get_temp_dir();
        $memory_dsn = "sqlite::memory:";

        return array(
            "Stash - sys_get_temp_dir()"      => [ "stash",       $tmp_dir ],
            "Symfony - sys_get_temp_dir()"    => [ "symfony",     $tmp_dir ],
            "automatic - sys_get_temp_dir()"  => [ "auto", $tmp_dir ],
            "Symfony  - $memory_dsn"          => [ "symfony", $memory_dsn ],
            "automatic - $memory_dsn"         => [ "auto",    $memory_dsn ],
        );
    }



    /**
     * @dataProvider provideUnsuitableDsnStrings
     * @todo Remove suppress errors '@' operator when Stash has upgraded their method signatures.
     */
    public function testExceptionOnWrongDsn(string $keyword, string $dsn_or_path) : void
    {

        SqliteCacheItemPoolFactory::$cache_engine = $keyword;

        $this->expectException(\UnexpectedValueException::class);
        $sut = new SqliteCacheItemPoolFactory($dsn_or_path);
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        if ($keyword == "stash")
            $result = @$sut("namespace");
        else {
            $result = $sut("namespace");
        }
    }


    public function provideUnsuitableDsnStrings() : array
    {
        $tmp_dir = sys_get_temp_dir();
        $memory_dsn = "sqlite::memory:";
        $filedsn = "sqlite:" . sys_get_temp_dir() . "/symfony-cache.sqlite3";

        return array(
            "Stash - $memory_dsn" => [ "stash",   $memory_dsn ],
            "Stash - $filedsn"    => [ "stash",   $filedsn ],
        );
    }


}
