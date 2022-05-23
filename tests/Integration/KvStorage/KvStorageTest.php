<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration\KvStorage;

use Abrouter\Client\Config\Config;
use Abrouter\Client\Tests\Integration\IntegrationTestCase;

class KvStorageTest extends IntegrationTestCase
{
    public function testBasic()
    {
        $this->configureParallelRun();
        $this->clearRedis();

        $config = $this->getContainer()->get(Config::class);

        $this->assertNull($config->getKvStorage()->get('zhopa'));
        $config->getKvStorage()->put('zhopa1', "1vvvq");
        $this->assertEquals($config->getKvStorage()->get('zhopa1'), "1vvvq");
        $config->getKvStorage()->remove('zhopa1');
        $this->assertNull($config->getKvStorage()->get('zhopa1'));
    }

    public function testExpire()
    {
        $this->configureParallelRun();
        $this->clearRedis();

        $config = $this->getContainer()->get(Config::class);

        $k = 'barebukh';
        $v = 'qq';
        $this->assertNull($config->getKvStorage()->get($k));
        $config->getKvStorage()->put($k, $v, 1);
        $this->assertEquals($config->getKvStorage()->get($k), $v);
        sleep(2);
        $this->assertNull($config->getKvStorage()->get($k));
    }
}
