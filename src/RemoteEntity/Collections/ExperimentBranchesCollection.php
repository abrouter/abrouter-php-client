<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Collections;

use Abrouter\Client\RemoteEntity\Entities\ExperimentBranch;

class ExperimentBranchesCollection
{
    /**
     * @var ExperimentBranch[]
     */
    private array $experimentBranches;

    /**
     * @var string
     */
    private ?string $experimentId;

    public function __construct(string $experimentId = null, ExperimentBranch ...$branches)
    {
        $this->experimentBranches = $branches;
        $this->experimentId = $experimentId;
    }

    /**
     * @return ExperimentBranch[]
     */
    public function getExperimentBranches(): array
    {
        return $this->experimentBranches;
    }

    /**
     * @return string
     */
    public function getExperimentId(): ?string
    {
        return $this->experimentId;
    }
}
