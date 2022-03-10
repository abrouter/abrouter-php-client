<?php
namespace Abrouter\Client\Tests\Unit\Managers;

use Abrouter\Client\Client;
use Abrouter\Client\Manager\ExperimentManager;
use Abrouter\Client\Manager\FeatureFlagManager;
use Abrouter\Client\Manager\StatisticsManager;
use Abrouter\Client\Tests\Unit\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client $client
     */
    private Client $client;
    
    public function setUp(): void
    {
        $this->bindConfig();
        $this->client = $this->getContainer()->make(Client::class);
    }
    
    public function testExperiments()
    {
        $this->assertInstanceOf(ExperimentManager::class, $this->client->experiments());
    }

    public function testFeatureFlag()
    {
        $this->assertInstanceOf(FeatureFlagManager::class, $this->client->featureFlags());
    }

    public function testStatistics()
    {
        $this->assertInstanceOf(StatisticsManager::class, $this->client->statistics());
    }
}
