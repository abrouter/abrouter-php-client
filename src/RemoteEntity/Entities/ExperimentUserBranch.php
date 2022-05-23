<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Entities;

class ExperimentUserBranch
{
    /**
     * @var string
     */
    private string $branchUid;

    private string $experimentUid;

    public function __construct(string $branchUid, $experimentUid)
    {
        $this->branchUid = $branchUid;
        $this->experimentUid = $experimentUid;
    }

    /**
     * @return string
     */
    public function getBranchUid(): string
    {
        return $this->branchUid;
    }

    /**
     * @return string
     */
    public function getExperimentUid(): string
    {
        return $this->experimentUid;
    }
}
