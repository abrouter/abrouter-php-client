<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\Config\Accessors\HostConfigAccessor;
use Abrouter\Client\Tests\Unit\TestCase;

class HostConfigAccessorTest extends TestCase
{
    /**
     * @var HostConfigAccessor $HostConfigAccessor
     */
    private $hostConfigAccessor;
    
    public function setUp(): void
    {
        $this->bindConfig();
        $this->hostConfigAccessor = $this->getContainer()->make(HostConfigAccessor::class);
    }
    
    public function testHostConfigAccessor()
    {
        $this->assertEquals($this->hostConfigAccessor->getHost(), $this->getConfig()->getHost());
    }
}
