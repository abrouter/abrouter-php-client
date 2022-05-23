<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Entities;

use Abrouter\Client\RemoteEntity\Entities\ExperimentRanResult;
use Abrouter\Client\Tests\Unit\TestCase;

class RunExperimentTest extends TestCase
{
    public function testRunExperiment()
    {
        $branchId = uniqid();
        $experimentId = uniqid();

        $runExperiment = new ExperimentRanResult($branchId, $experimentId);
        $this->assertEquals($runExperiment->getExperimentId(), $experimentId);
        $this->assertEquals($runExperiment->getBranchId(), $branchId);
    }
}
