<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Support\Experiments;

use Abrouter\Client\Builders\Payload\ExperimentRunPayloadBuilder;
use Abrouter\Client\Entities\RunExperiment;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\RunExperimentRequestException;
use Abrouter\Client\Manager\ExperimentManager;
use Abrouter\Client\Requests\RunExperimentRequest;
use Abrouter\Client\Support\Experiments\RunOfflineModeProxy;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Transformers\RunExperimentRequestTransformer;

class RunOfflineModeProxyTest extends TestCase
{
    /**
     * @var ExperimentManager
     */
    private $experimentManager;
    
    /**
     * @var RunOfflineModeProxy
     */
    private $runOfflineModeProxy;
    
    public function setUp(): void
    {
        $this->bindConfig();
        
        $runExperimentRequest = $this->getContainer()->make(RunExperimentRequest::class);
        $experimentRunPayloadBuilder = $this->getContainer()->make(ExperimentRunPayloadBuilder::class);
        $runExperimentRequestTransformer = $this->getContainer()->make(RunExperimentRequestTransformer::class);
        
        $this->experimentManager = new class (
            $runExperimentRequest,
            $experimentRunPayloadBuilder,
            $runExperimentRequestTransformer
        ) extends ExperimentManager {
            public function run(string $userSignature, string $experimentUid): RunExperiment
            {
                throw new RunExperimentRequestException('cURL error 6: Could not resolve host: abrouter.com');
            }
        };
        $this->runOfflineModeProxy = new RunOfflineModeProxy($this->experimentManager);
    }
    
    /**
     * @throws InvalidJsonApiResponseException
     */
    public function testRunOffline()
    {
        $defaultBranch = uniqid();
        $experimentUid = uniqid();
        
        $runExperiment = $this->runOfflineModeProxy->runOffline(uniqid(), uniqid(), $experimentUid, $defaultBranch);
        
        $this->assertEquals($runExperiment->getExperimentId(), $experimentUid);
        $this->assertEquals($runExperiment->getBranchId(), $defaultBranch);
    }
}
