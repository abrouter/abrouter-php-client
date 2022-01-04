<?php
declare(strict_types = 1);

namespace Abrouter\Client;

use Abrouter\Client\Manager\ExperimentManager;

class Client
{
    /**
     * @var ExperimentManager
     */
    private ExperimentManager $experimentManager;
    
    public function __construct(
        ExperimentManager $experimentManager,
        StatisticsManager $statisticsManager
    ) {
        $this->experimentManager = $experimentManager;
        $this->statisticsManager = $statisticsManager;
    }
    
    public function experiments(): ExperimentManager
    {
        return $this->experimentManager;
    }

    public function statistics(): StatisticsManager
    {
        return $this->statisticsManager;
    }
}
