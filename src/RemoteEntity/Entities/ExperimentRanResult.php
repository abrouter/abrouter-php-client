<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Entities;

class ExperimentRanResult
{
    /**
     * @var string
     */
    private string $branchId;

    /**
     * @var string
     */
    private string $experimentId;

    public function __construct(string $branchId, string $experimentId)
    {
        $this->branchId = $branchId;
        $this->experimentId = $experimentId;
    }

    /**
     * @return string
     */
    public function getBranchId(): string
    {
        return $this->branchId;
    }

    /**
     * @return string
     */
    public function getExperimentId(): string
    {
        return $this->experimentId;
    }
}
