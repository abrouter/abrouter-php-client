<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\ExperimentsParallelRun;

use Abrouter\Client\Contracts\TaskContract;

class AddUserToBranchTask implements TaskContract
{
    /**
     * @var string
     */
    private string $experimentId;

    /**
     * @var string
     */
    private string $userSignature;

    /**
     * @var string
     */
    private string $branch;

    private string $experimentAlias;

    public function __construct(string $experimentAlias, string $experimentId, string $userSignature, string $branch)
    {
        $this->experimentId = $experimentId;
        $this->userSignature = $userSignature;
        $this->branch = $branch;
        $this->experimentAlias = $experimentAlias;
    }

    /**
     * @return string
     */
    public function getExperimentId(): string
    {
        return $this->experimentId;
    }

    /**
     * @return string
     */
    public function getUserSignature(): string
    {
        return $this->userSignature;
    }

    /**
     * @return string
     */
    public function getBranch(): string
    {
        return $this->branch;
    }

    /**
     * @return string
     */
    public function getExperimentAlias(): string
    {
        return $this->experimentAlias;
    }
}
