<?php
namespace tests;

use Germania\NamespacedCache\StashSqliteCacheItemPoolFactory;
use Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;
use Psr\Cache\CacheItemPoolInterface;

class StashSqliteCacheItemPoolFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testInstantiation() : StashSqliteCacheItemPoolFactory
    {
        $sut = new StashSqliteCacheItemPoolFactory;
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     */
    public function testFactoryMethod(StashSqliteCacheItemPoolFactory $sut) : void
    {
        $result = $sut("namespace");
        $this->assertInstanceOf(CacheItemPoolInterface::class, $result);
    }


}
