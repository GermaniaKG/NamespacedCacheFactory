<?php
namespace tests;

use Germania\NamespacedCache\StashFileCacheItemPoolFactory;
use Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;
use Psr\Cache\CacheItemPoolInterface;

class StashFileCacheItemPoolFactoryTest extends \PHPUnit\Framework\TestCase
{


    public function testInstantiation() : StashFileCacheItemPoolFactory
    {
        $path = sys_get_temp_dir();
        $sut = new StashFileCacheItemPoolFactory($path);
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     * @todo Remove suppress errors '@' operator when Stash has upgraded their method signatures.
     */
    public function testFactoryMethod(StashFileCacheItemPoolFactory $sut) : void
    {
        $result = @$sut("namespace");
        $this->assertInstanceOf(CacheItemPoolInterface::class, $result);
    }

}
