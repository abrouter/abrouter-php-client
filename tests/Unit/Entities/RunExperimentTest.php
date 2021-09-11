<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Entities;

use Abrouter\Client\Entities\RunExperiment;
use Abrouter\Client\Tests\Unit\TestCase;

class RunExperimentTest extends TestCase
{
    public function testRunExperiment()
    {
        $branchId = uniqid();
        $experimentId = uniqid();
        
        $runExperiment = new RunExperiment($branchId, $experimentId);
        $this->assertEquals($runExperiment->getExperimentId(), $experimentId);
        $this->assertEquals($runExperiment->getBranchId(), $branchId);
    }
}
