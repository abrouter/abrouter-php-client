<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\Experiments;

use Abrouter\Client\RemoteEntity\Entities\ExperimentRanResult;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\RunExperimentRequestException;
use Abrouter\Client\Manager\ExperimentManager;

class RunOfflineModeProxy
{
    /**
     * @var ExperimentManager
     */
    private ExperimentManager $experimentManager;

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
     * @return ExperimentRanResult
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
            return new ExperimentRanResult($defaultBranchId, $experimentUid);
        }
    }
}
