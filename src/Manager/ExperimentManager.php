<?php

declare(strict_types=1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Builders\Payload\ExperimentRunPayloadBuilder;
use Abrouter\Client\RemoteEntity\Entities\ExperimentRanResult;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\RunExperimentRequestException;
use Abrouter\Client\Requests\RunExperimentRequest;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunner;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Transformers\RunExperimentRequestTransformer;

class ExperimentManager
{
    /**
     * @var RunExperimentRequest
     */
    private RunExperimentRequest $runExperimentRequest;

    /**
     * @var ExperimentRunPayloadBuilder
     */
    private ExperimentRunPayloadBuilder $experimentRunPayloadBuilder;

    /**
     * @var RunExperimentRequestTransformer
     */
    private RunExperimentRequestTransformer $experimentRequestTransformer;

    private ParallelRunSwitch $parallelRunSwitch;

    private ParallelRunner $parallelRunner;

    public function __construct(
        RunExperimentRequest $runExperimentRequest,
        ExperimentRunPayloadBuilder $experimentRunPayloadBuilder,
        RunExperimentRequestTransformer $experimentRequestTransformer,
        ParallelRunSwitch $parallelRunSwitch,
        ParallelRunner $parallelRunner
    ) {
        $this->runExperimentRequest = $runExperimentRequest;
        $this->experimentRunPayloadBuilder = $experimentRunPayloadBuilder;
        $this->experimentRequestTransformer = $experimentRequestTransformer;
        $this->parallelRunSwitch = $parallelRunSwitch;
        $this->parallelRunner = $parallelRunner;
    }

    /**
     * @param string $userSignature
     * @param string $experimentUid
     *
     * @return ExperimentRanResult
     */
    public function run(string $userSignature, string $experimentUid): ExperimentRanResult
    {
        if ($this->parallelRunSwitch->isEnabled()) {
            return $this->runInParallel($userSignature, $experimentUid);
        }

        return $this->runSync($userSignature, $experimentUid);
    }

    private function runSync(string $userSignature, string $experimentUid): ExperimentRanResult
    {
        $payload = $this->experimentRunPayloadBuilder->build($userSignature, $experimentUid);
        $response = $this->runExperimentRequest->runExperiment($payload);
        $runExperiment = $this->experimentRequestTransformer->transform($response);

        return $runExperiment;
    }

    private function runInParallel(string $userSignature, string $experimentAlias): ExperimentRanResult
    {
        return $this->parallelRunner->run($userSignature, $experimentAlias);
    }
}
