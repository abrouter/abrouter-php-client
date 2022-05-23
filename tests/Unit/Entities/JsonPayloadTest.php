<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Entities;

use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Tests\Unit\TestCase;

class JsonPayloadTest extends TestCase
{
    public function testJsonPayload()
    {
        $expected = ['test' => true];
        $jsonPayload = new JsonPayload($expected);
        $this->assertEquals($jsonPayload->getPayload(), $expected);
    }
}
