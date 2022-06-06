<?php

declare(strict_types=1);

namespace Abrouter\Client;

use Abrouter\Client\Config\Accessors\ParallelRunConfigAccessor;
use Abrouter\Client\Contracts\TaskManagerContract;

class Worker
{
    private TaskManagerContract $taskManager;

    public function __construct(ParallelRunConfigAccessor $parallelRunConfigAccessor)
    {
        $this->taskManager = $parallelRunConfigAccessor->getTaskManager();
    }

    public function work(int $iterationsLimit = 0)
    {
        $this->taskManager->work($iterationsLimit);
    }
}
