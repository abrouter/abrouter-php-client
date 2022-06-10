<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\TaskManager;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\Contracts\TaskManagerContract;
use Abrouter\Client\Events\EventDispatcher;

class TaskManager implements TaskManagerContract
{
    private TaskStorage $taskStorage;

    private EventDispatcher $eventDispatcher;

    public function __construct(TaskStorage $taskStorage, EventDispatcher $eventDispatcher)
    {
        $this->taskStorage = $taskStorage;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function queue(TaskContract $task): void
    {
        $this->taskStorage->publish($task);
    }

    public function work(int $iterationsLimit = 0): void
    {
        $this->taskStorage->subscribe(function (TaskContract $taskContract) {
            $this->eventDispatcher->dispatch($taskContract, false);
        }, $iterationsLimit);
    }
}
