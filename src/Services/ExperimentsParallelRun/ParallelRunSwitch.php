<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\ExperimentsParallelRun;

use Abrouter\Client\Config\Accessors\ParallelRunConfigAccessor;

class ParallelRunSwitch
{
    private ParallelRunConfigAccessor $parallelRunConfigAccessor;

    public function __construct(ParallelRunConfigAccessor $parallelRunConfigAccessor)
    {
        $this->parallelRunConfigAccessor = $parallelRunConfigAccessor;
    }

    public function isEnabled(): bool
    {
        if (!$this->parallelRunConfigAccessor->isEnabled()) {
            return false;
        }

        if ($this->parallelRunConfigAccessor->getKvStorage() === null) {
            return false;
        }

        if ($this->parallelRunConfigAccessor->getTaskManager() === null) {
            return false;
        }

        return true;
    }
}
