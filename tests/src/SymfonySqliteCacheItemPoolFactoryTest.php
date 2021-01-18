<?php
namespace tests;

use Germania\NamespacedCache\SymfonySqliteCacheItemPoolFactory;
use Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;
use Psr\Cache\CacheItemPoolInterface;

class SymfonySqliteCacheItemPoolFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testInstantiation() : SymfonySqliteCacheItemPoolFactory
    {
        $sut = new SymfonySqliteCacheItemPoolFactory;
        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     */
    public function testFactoryMethod(SymfonySqliteCacheItemPoolFactory $sut) : void
    {
        $result = $sut("namespace");
        $this->assertInstanceOf(CacheItemPoolInterface::class, $result);
    }


}
