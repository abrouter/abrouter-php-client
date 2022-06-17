<?php

declare(strict_types=1);

namespace Abrouter\Client;

use Abrouter\Client\Manager\ExperimentManager;
use Abrouter\Client\Manager\FeatureFlagManager;
use Abrouter\Client\Manager\StatisticsManager;

class Client
{
    /**
     * @var ExperimentManager
     */
    private ExperimentManager $experimentManager;

    /**
     * @var StatisticsManager
     */
    private StatisticsManager $statisticsManager;

    /**
     * @var FeatureFlagManager
     */
    private FeatureFlagManager $featureFlagManager;

    public function __construct(
        ExperimentManager $experimentManager,
        FeatureFlagManager $featureFlagManager,
        StatisticsManager $statisticsManager
    ) {
        $this->experimentManager = $experimentManager;
        $this->featureFlagManager = $featureFlagManager;
        $this->statisticsManager = $statisticsManager;
    }

    public function experiments(): ExperimentManager
    {
        return $this->experimentManager;
    }

    public function featureFlags(): FeatureFlagManager
    {
        return $this->featureFlagManager;
    }

    public function statistics(): StatisticsManager
    {
        return $this->statisticsManager;
    }
}
