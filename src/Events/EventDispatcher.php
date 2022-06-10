<?php

declare(strict_types=1);

namespace Abrouter\Client\Events;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\Services\TaskManager\TaskStorage;

class EventDispatcher
{
    private EventHandlersMap $eventHandlersMap;

    private TaskStorage $taskStorage;

    public function __construct(EventHandlersMap $eventHandlersMap, TaskStorage $taskStorage)
    {
        $this->eventHandlersMap = $eventHandlersMap;
        $this->taskStorage = $taskStorage;
    }

    public function dispatch(TaskContract $taskContract, bool $async = false): void
    {
        if ($async) {
            $this->taskStorage->publish($taskContract);
            return ;
        }

        $handlers = $this->eventHandlersMap->getTaskHandlers($taskContract);
        if ($handlers === null) {
            return ;
        }

        foreach ($handlers as $handler) {
            $handler->handle($taskContract);
        }
    }
}
