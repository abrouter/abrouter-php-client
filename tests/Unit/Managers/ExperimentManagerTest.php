<?php
namespace Abrouter\Client\Tests\Unit\Managers;

use Abrouter\Client\Builders\Payload\ExperimentRunPayloadBuilder;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Client\ResponseInterface;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Manager\ExperimentManager;
use Abrouter\Client\Tests\Unit\TestCase;
use \Abrouter\Client\Requests\RunExperimentRequest;
use Abrouter\Client\Transformers\RunExperimentRequestTransformer;

class ExperimentManagerTest extends TestCase
{
    public function testRunExperiment()
    {
        $branchId = 'form';
        $experimentId = 'color-red';
        
        $runExperimentRequest = new class () extends RunExperimentRequest {
            public function __construct()
            {
            }
    
            public function runExperiment(JsonPayload $jsonPayload): ResponseInterface
            {
                return new Response([
                    'data' => [
                        'id' => uniqid(),
                        'type' => 'experiment_branch_users',
                        'attributes' => [
                            'run-uid' => 'form-color-red',
                            'branch-uid' => 'form',
                            'experiment-uid' => 'color-red',
                        ],
                    ]
                ]);
            }
        };
        
        
        $experimentManager = new ExperimentManager(
            $runExperimentRequest,
            $this->getContainer()->make(ExperimentRunPayloadBuilder::class),
            $this->getContainer()->make(RunExperimentRequestTransformer::class),
        );
        $userSignature = uniqid();
        $abrExperimentId = uniqid();
        $runExperimentEntity = $experimentManager->run($userSignature, $abrExperimentId);
    
        $this->assertEquals($runExperimentEntity->getBranchId(), $branchId);
        $this->assertEquals($runExperimentEntity->getExperimentId(), $experimentId);
    }
}
