<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\Builders\ConfigBuilder;
use Abrouter\Client\Config\Config;
use Abrouter\Client\Tests\Unit\TestCase;

class ConfigBuilderTest extends TestCase
{
    /**
     * @var ConfigBuilder $configBuilder
     */
    private ConfigBuilder $configBuilder;
    
    public function setUp(): void
    {
        $this->configBuilder = $this->getContainer()->make(ConfigBuilder::class);
    }
    
    public function testBuild()
    {
        $host = 'https://example.com';
        $token = uniqid();
        
        $config = $this->configBuilder
            ->setHost($host)
            ->setToken($token)
            ->build();
        
        $this->assertInstanceOf(Config::class, $config);
        $this->assertEquals($config->getToken(), $token);
        $this->assertEquals($config->getHost(), $host);
    }
}
