<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration\Cacher;

use Abrouter\Client\RemoteEntity\Cache\Cacher;
use Abrouter\Client\Tests\Integration\IntegrationTestCase;

class CacherTest extends IntegrationTestCase
{
    public function testCacher()
    {
        $this->configureParallelRun();

        $cacher = $this->getContainer()->make(Cacher::class);

        $obj = new \stdClass();
        $obj->test = 'test';
        $value = $cacher->fetch('bla-bla', 'type', 5, function () use ($obj) {
            return $obj;
        });

        $this->assertEquals($value, $obj);
    }
}
