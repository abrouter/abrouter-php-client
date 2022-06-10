<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Entities\Client;

use Abrouter\Client\Entities\Client\Request;
use Abrouter\Client\Tests\Unit\TestCase;

class RequestTest extends TestCase
{
    public function testJsonPayload()
    {
        $method = 'post';
        $url = '/';
        $payload = ['test' => true];
        $headers = [
            'Authorization' => 'Bearer ' . uniqid(),
        ];

        $jsonPayload = new Request($method, $url, $payload, $headers);
        $this->assertEquals($jsonPayload->getMethod(), $method);
        $this->assertEquals($jsonPayload->getUrl(), $url);
        $this->assertEquals($jsonPayload->getPayload(), $payload);
        $this->assertEquals($jsonPayload->getHeaders(), $headers);
    }
}
