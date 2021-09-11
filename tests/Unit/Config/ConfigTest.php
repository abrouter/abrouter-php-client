<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\Config\Config;
use Abrouter\Client\Tests\Unit\TestCase;

class ConfigTest extends TestCase
{
    public function testHostConfigAccessor()
    {
        $token = uniqid();
        $host = 'https://127.0.0.1';
        
        $config = new Config($token, $host);
        $this->assertEquals($config->getToken(), $token);
        $this->assertEquals($config->getHost(), $host);
    }
}
