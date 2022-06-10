<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Entities\Client;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Tests\Unit\TestCase;

class ResponseTest extends TestCase
{
    public function testJsonPayload()
    {
        $expectedResponse = [
            'test' => 1,
        ];

        $response = new Response($expectedResponse);
        $this->assertEquals($response->getResponseJson(), $expectedResponse);
    }
}
