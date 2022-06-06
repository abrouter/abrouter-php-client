<?php

declare(strict_types=1);

namespace Abrouter\Client\Config\Accessors;

use Abrouter\Client\Contracts\KvStorageContract;
use Abrouter\Client\Contracts\TaskManagerContract;

class ParallelRunConfigAccessor extends BaseAccessor
{
    public function isEnabled(): bool
    {
        if ($this->getConfig()->getParallelRunConfig() === null) {
            return false;
        }

        return $this->getConfig()->getParallelRunConfig()->isEnabled();
    }

    public function getKvStorage(): ?KvStorageContract
    {
        return $this->getConfig()->getKvStorage();
    }

    public function getTaskManager(): ?TaskManagerContract
    {
        if ($this->getConfig()->getParallelRunConfig() === null) {
            return null;
        }

        return $this->getConfig()->getParallelRunConfig()->getTaskManager();
    }
}
