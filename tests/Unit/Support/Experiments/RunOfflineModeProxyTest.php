<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Services\Experiments;

use Abrouter\Client\Builders\Payload\ExperimentRunPayloadBuilder;
use Abrouter\Client\RemoteEntity\Entities\ExperimentRanResult;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\RunExperimentRequestException;
use Abrouter\Client\Manager\ExperimentManager;
use Abrouter\Client\Requests\RunExperimentRequest;
use Abrouter\Client\Services\Experiments\RunOfflineModeProxy;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunner;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Transformers\RunExperimentRequestTransformer;

class RunOfflineModeProxyTest extends TestCase
{
    /**
     * @var ExperimentManager
     */
    private ExperimentManager $experimentManager;

    /**
     * @var RunOfflineModeProxy
     */
    private RunOfflineModeProxy $runOfflineModeProxy;

    public function setUp(): void
    {
        $this->bindConfig();

        $runExperimentRequest = $this->getContainer()->make(RunExperimentRequest::class);
        $experimentRunPayloadBuilder = $this->getContainer()->make(ExperimentRunPayloadBuilder::class);
        $runExperimentRequestTransformer = $this->getContainer()->make(RunExperimentRequestTransformer::class);
        $parallelRunSwitch = $this->getContainer()->make(ParallelRunSwitch::class);
        $parallelRunner = $this->getContainer()->make(ParallelRunner::class);

        $this->experimentManager = new class (
            $runExperimentRequest,
            $experimentRunPayloadBuilder,
            $runExperimentRequestTransformer,
            $parallelRunSwitch,
            $parallelRunner
        ) extends ExperimentManager {
            public function run(string $userSignature, string $experimentUid): ExperimentRanResult
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
