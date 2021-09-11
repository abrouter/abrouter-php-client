<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\RunExperiment;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Transformers\RunExperimentRequestTransformer;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;

class RunExperimentTransformerTest extends TestCase
{
    /**
     * @var RunExperimentRequestTransformer $runExperimentRequestTransformer
     */
    private RunExperimentRequestTransformer $runExperimentRequestTransformer;
    
    public function setUp(): void
    {
        $this->runExperimentRequestTransformer = $this->getContainer()->make(RunExperimentRequestTransformer::class);
    }
    
    /**
     * @throws InvalidJsonApiResponseException
     */
    public function testTransform()
    {
        $branchUid = uniqid();
        $experimentUid = uniqid();
        
        $runExperiment = $this->runExperimentRequestTransformer->transform(new Response([
            'data' => [
                'type' => 'experiment_branch_users',
                'id' => uniqid(),
                'attributes' => [
                    'branch-uid' => $branchUid,
                    'experiment-uid' => $experimentUid,
                ],
            ],
        ]));
        
        $this->assertInstanceOf(RunExperiment::class, $runExperiment);
        $this->assertEquals($runExperiment->getBranchId(), $branchUid);
        $this->assertEquals($runExperiment->getExperimentId(), $experimentUid);
    }
    
    /**
     * @throws InvalidJsonApiResponseException
     */
    public function testException()
    {
        $this->expectException(InvalidJsonApiResponseException::class);
        $this->runExperimentRequestTransformer->transform(new Response([
            'data' => [],
        ]));
    }
}
