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
        $this->configureParallelRun('default');
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);

        $this->assertTrue($client->featureFlags()->run('enabled'));
        $this->assertTrue($client->featureFlags()->run('enabled'));
    }

    public function testDisabled()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);

        $this->assertFalse($client->featureFlags()->run('disabled'));
        $this->assertFalse($client->featureFlags()->run('disabled'));
    }
}
