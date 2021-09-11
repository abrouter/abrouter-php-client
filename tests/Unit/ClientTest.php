<?php
namespace Abrouter\Client\Tests\Unit\Managers;

use Abrouter\Client\Client;
use Abrouter\Client\Manager\ExperimentManager;
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
}
