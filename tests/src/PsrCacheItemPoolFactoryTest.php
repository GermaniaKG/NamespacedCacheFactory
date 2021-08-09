<?php
namespace tests;

use Germania\NamespacedCache\PsrCacheItemPoolFactory;
use Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;

class PsrCacheItemPoolFactoryTest extends \PHPUnit\Framework\TestCase
{


    public function testAutodiscover() : void
    {
        $path = sys_get_temp_dir();
        $path = sys_get_temp_dir();

        $result = PsrCacheItemPoolFactory::autodiscover($path, 10);

        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $result);

    }



}
