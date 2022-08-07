<?php

declare(strict_types=1);

namespace Abrouter\Client\Events;

use Abrouter\Client\Config\Accessors\ParallelRunConfigAccessor;
use Abrouter\Client\Contracts\TaskContract;

class EventDispatcher
{
    private EventHandlersMap $eventHandlersMap;

    private ParallelRunConfigAccessor $parallelRunConfigAccessor;

    public function __construct(
        EventHandlersMap $eventHandlersMap,
        ParallelRunConfigAccessor $parallelRunConfigAccessor
    ) {
        $this->eventHandlersMap = $eventHandlersMap;
        $this->parallelRunConfigAccessor = $parallelRunConfigAccessor;
    }

    public function dispatch(TaskContract $taskContract, bool $async = false): void
    {
        if ($async) {
            $this->parallelRunConfigAccessor->getTaskManager()->queue($taskContract);
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
