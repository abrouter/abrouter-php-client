<?php
declare(strict_types = 1);

namespace Abrouter\Client;

use Abrouter\Client\Manager\ExperimentManager;

class Client
{
    /**
     * @var ExperimentManager
     */
    private $experimentManager;
    
    public function __construct(ExperimentManager $experimentManager)
    {
        $this->experimentManager = $experimentManager;
    }
    
    public function experiments(): ExperimentManager
    {
        return $this->experimentManager;
    }
}
