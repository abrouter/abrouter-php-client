<?php

declare(strict_types=1);

namespace Abrouter\Client\Config;

use Abrouter\Client\Contracts\TaskManagerContract;

class ParallelRunConfig
{
    /**
     * @var bool
     */
    private $enabled;

    private ?TaskManagerContract $taskManager;

    public function __construct(bool $enabled, TaskManagerContract $taskManager = null)
    {
        $this->enabled = $enabled;
        $this->taskManager = $taskManager;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return TaskManagerContract|null
     */
    public function getTaskManager(): ?TaskManagerContract
    {
        return $this->taskManager;
    }
}
