<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit;

use Abrouter\Client\Config\Config;
use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    private const TEST_HOST = 'https://127.0.0.1';
    
    /**
     * @var Container $container
     */
    private Container $container;
    
    /**
     * @var string $token
     */
    private string $token;
    
    /**
     * @var string $host
     */
    private string $host;
    
    public function getContainer()
    {
        if (isset($this->container)) {
            return $this->container;
        }
    
        $containerBuilder = new ContainerBuilder();
        $container = $containerBuilder->build();
        $this->container = $container;
        return $container;
    }
    
    protected function bindConfig(): void
    {
        $this->host = self::TEST_HOST;
        $this->token = uniqid();
        
        $config = new Config($this->token, $this->host);
        $this->getContainer()->set(Config::class, $config);
    }
    
    public function getConfig(): Config
    {
        return $this->getContainer()->get(Config::class);
    }
}
