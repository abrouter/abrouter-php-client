<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration\ParallelRun;

use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Tests\Integration\IntegrationTestCase;

class ParallelRunSwitchTest extends IntegrationTestCase
{
    public function testSwitchEnabled()
    {
        $this->configureParallelRun();

        $switch = $this->getContainer()->make(ParallelRunSwitch::class);
        $this->assertTrue($switch->isEnabled());
    }

    public function testSwitchDisabled()
    {
        $this->bindConfig();

        $switch = $this->getContainer()->make(ParallelRunSwitch::class);
        $this->assertFalse($switch->isEnabled());
    }
}
