<?php
namespace tests;

use Stash\Pool as StashPool;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as SymfonyFileSystem;
use Germania\NamespacedCache\FileCacheItemPoolFactory;
use Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;
use Psr\Cache\CacheItemPoolInterface;

class FileCacheItemPoolFactoryTest extends \PHPUnit\Framework\TestCase
{


    public function testInstantiation() : FileCacheItemPoolFactory
    {
        $path = sys_get_temp_dir();
        $sut = new FileCacheItemPoolFactory($path);
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     * @todo Remove suppress errors '@' operator when Stash has upgraded their method signatures.
     */
    public function testFactoryMethod(FileCacheItemPoolFactory $sut) : void
    {
        $result = @$sut("namespace");
        $this->assertInstanceOf(CacheItemPoolInterface::class, $result);
    }




    /**
     * @dataProvider provideCacheFactoryKeywords
     * @todo Remove suppress errors '@' operator when Stash has upgraded their method signatures.
     */
    public function testForceFactoryMethod(string $keyword) : void
    {

        $path = sys_get_temp_dir();
        FileCacheItemPoolFactory::$cache_engine = $keyword;

        $sut = new FileCacheItemPoolFactory($path);
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        $result = @$sut("namespace");
        $this->assertInstanceOf(CacheItemPoolInterface::class, $result);

        switch($keyword):
            case "stash":
                $this->assertInstanceOf(StashPool::class, $result);
                break;
            case "symfony":
                $this->assertInstanceOf(SymfonyFileSystem::class, $result);
                break;
            default:
                break;
        endswitch;
    }


    public function provideCacheFactoryKeywords() : array
    {
        return array(
            "automatic"     => [ "auto" ],
            "Force Symfony" => [ "symfony" ],
            "Force Stash"   => [ "stash" ]
        );
    }


}
