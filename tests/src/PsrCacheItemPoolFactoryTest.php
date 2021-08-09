<?php
namespace tests;

use Germania\NamespacedCache\PsrCacheItemPoolFactory;
use Germania\NamespacedCache\PsrCacheItemPoolFactoryInterface;
use Germania\NamespacedCache\Exceptions;

class PsrCacheItemPoolFactoryTest extends \PHPUnit\Framework\TestCase
{


    public function testAutodiscover() : void
    {
        $path = sys_get_temp_dir();
        $path = sys_get_temp_dir();

        try {
            $result = PsrCacheItemPoolFactory::autodiscover($path, 10);
        }
        catch (Exceptions\SQliteDsnRequired $e) {
            $result = PsrCacheItemPoolFactory::autodiscover("sqlite::memory:", 10);
        }


        $this->assertInstanceOf(PsrCacheItemPoolFactoryInterface::class, $result);

    }



}
