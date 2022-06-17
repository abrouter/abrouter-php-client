<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration;

use Abrouter\Client\Client;
use Abrouter\Client\RemoteEntity\Repositories\UserEventsRepository;
use Abrouter\Client\Worker;

class FeatureFlagParallelTest extends IntegrationTestCase
{
    public function testEnabled()
    {
        $this->configureParallelRun('add73bda37106bbddf2e6b3f61c6ed197c2250e99df9474ad01b9afb2035af33cf66c292fdf6a6e8');
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);

        $this->assertTrue($client->featureFlags()->run('enabled'));
        $this->assertTrue($client->featureFlags()->run('enabled'));
    }

    public function testDisabled()
    {
        $this->configureParallelRun('add73bda37106bbddf2e6b3f61c6ed197c2250e99df9474ad01b9afb2035af33cf66c292fdf6a6e8');
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);

        $this->assertFalse($client->featureFlags()->run('disabled'));
        $this->assertFalse($client->featureFlags()->run('disabled'));
    }
}
