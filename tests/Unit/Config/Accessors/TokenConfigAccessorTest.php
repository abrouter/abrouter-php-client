<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\Config\Accessors\TokenConfigAccessor;
use Abrouter\Client\Tests\Unit\TestCase;

class TokenConfigAccessorTest extends TestCase
{
    /**
     * @var TokenConfigAccessor $tokenConfigAccessor
     */
    private TokenConfigAccessor $tokenConfigAccessor;

    public function setUp(): void
    {
        $this->bindConfig();
        $this->tokenConfigAccessor = $this->getContainer()->make(TokenConfigAccessor::class);
    }

    public function testHostConfigAccessor()
    {
        $this->assertEquals($this->getConfig()->getToken(), $this->getConfig()->getToken());
    }
}
