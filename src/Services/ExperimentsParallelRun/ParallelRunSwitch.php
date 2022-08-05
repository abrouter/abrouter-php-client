<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\ExperimentsParallelRun;

use Abrouter\Client\Config\Accessors\ParallelRunConfigAccessor;

class ParallelRunSwitch
{
    private ParallelRunConfigAccessor $parallelRunConfigAccessor;

    private ParallelRunInitializer $parallelRunInitializer;

    public function __construct(
        ParallelRunConfigAccessor $parallelRunConfigAccessor,
        ParallelRunInitializer $parallelRunInitializer
    ) {
        $this->parallelRunConfigAccessor = $parallelRunConfigAccessor;
        $this->parallelRunInitializer = $parallelRunInitializer;
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

        $this->parallelRunInitializer->initializeIfNot();

        return true;
    }
}
