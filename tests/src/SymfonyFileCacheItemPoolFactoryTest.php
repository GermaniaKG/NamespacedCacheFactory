<?php
namespace tests;

use Germania\NamespacedCache\SymfonyFileCacheItemPoolFactory;
use Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;
use Psr\Cache\CacheItemPoolInterface;

class SymfonyFileCacheItemPoolFactoryTest extends \PHPUnit\Framework\TestCase
{


    public function testInstantiation() : SymfonyFileCacheItemPoolFactory
    {
        $path = sys_get_temp_dir();
        $sut = new SymfonyFileCacheItemPoolFactory($path);
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     */
    public function testFactoryMethod(SymfonyFileCacheItemPoolFactory $sut) : void
    {
        $result = $sut("namespace");
        $this->assertInstanceOf(CacheItemPoolInterface::class, $result);
    }



}
