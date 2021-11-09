<?php
declare(strict_types = 1);

namespace Abrouter\Client\Support\Experiments;

use Abrouter\Client\Entities\RunExperiment;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\RunExperimentRequestException;
use Abrouter\Client\Manager\ExperimentManager;

class RunOfflineModeProxy
{
    /**
     * @var ExperimentManager
     */
    private $experimentManager;
    
    /**
     * OfflineModeProxy constructor.
     *
     * @param ExperimentManager $experimentManager
     */
    public function __construct(ExperimentManager $experimentManager)
    {
        $this->experimentManager = $experimentManager;
    }
    
    /**
     * @param string $userSignature
     * @param string $experimentId
     * @param string $experimentUid
     * @param string $defaultBranchId
     *
     * @return RunExperiment
     * @throws InvalidJsonApiResponseException
     */
    public function runOffline(
        string $userSignature,
        string $experimentId,
        string $experimentUid,
        string $defaultBranchId
    ) {
        try {
            return $this->experimentManager->run($userSignature, $experimentId);
        } catch (RunExperimentRequestException $runExperimentRequestException) {
            return new RunExperiment($defaultBranchId, $experimentUid);
        }
    }
}
