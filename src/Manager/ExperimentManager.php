<?php
declare(strict_types = 1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Builders\Payload\ExperimentRunPayloadBuilder;
use Abrouter\Client\Entities\RunExperiment;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\RunExperimentRequestException;
use Abrouter\Client\Requests\RunExperimentRequest;
use Abrouter\Client\Transformers\RunExperimentRequestTransformer;

class ExperimentManager
{
    /**
     * @var RunExperimentRequest
     */
    private $runExperimentRequest;
    
    /**
     * @var ExperimentRunPayloadBuilder
     */
    private $experimentRunPayloadBuilder;
    
    /**
     * @var RunExperimentRequestTransformer
     */
    private $experimentRequestTransformer;
    
    public function __construct(
        RunExperimentRequest $runExperimentRequest,
        ExperimentRunPayloadBuilder $experimentRunPayloadBuilder,
        RunExperimentRequestTransformer $experimentRequestTransformer
    ) {
        $this->runExperimentRequest = $runExperimentRequest;
        $this->experimentRunPayloadBuilder = $experimentRunPayloadBuilder;
        $this->experimentRequestTransformer = $experimentRequestTransformer;
    }
    
    /**
     * @param string $userSignature
     * @param string $experimentUid
     *
     * @return RunExperiment
     * @throws InvalidJsonApiResponseException
     * @throws RunExperimentRequestException
     */
    public function run(string $userSignature, string $experimentUid): RunExperiment
    {
        $payload = $this->experimentRunPayloadBuilder->build($userSignature, $experimentUid);
        $response = $this->runExperimentRequest->runExperiment($payload);
        $runExperiment = $this->experimentRequestTransformer->transform($response);
        
        return $runExperiment;
    }
}
