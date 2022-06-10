<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Collections;

use Abrouter\Client\RemoteEntity\Entities\ExperimentUserBranch;

class ExperimentUserBranchesCollection
{
    /**
     * @var ExperimentUserBranch[]
     */
    private array $experimentUserBranches;

    public function __construct(ExperimentUserBranch ...$branches)
    {
        $this->experimentUserBranches = $branches;
    }

    /**
     * @return ExperimentUserBranch[]
     */
    public function getAll(): array
    {
        return $this->experimentUserBranches;
    }
}
