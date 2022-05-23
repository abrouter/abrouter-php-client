<?php

declare(strict_types=1);

namespace Abrouter\Client\Events;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\Events\Handlers\AddUserToBranchHandler;
use Abrouter\Client\Events\Handlers\StatisticsSenderHandler;
use Abrouter\Client\Services\ExperimentsParallelRun\AddUserToBranchTask;
use Abrouter\Client\Services\Statistics\SendEventTask;

class EventHandlersMap
{
    private AddUserToBranchHandler $addUserToBranchHandler;

    private StatisticsSenderHandler $statisticsSenderHandler;

    private array $map;

    public function __construct(
        AddUserToBranchHandler $addUserToBranchHandler,
        StatisticsSenderHandler $statisticsSenderHandler
    ) {
        $this->addUserToBranchHandler = $addUserToBranchHandler;
        $this->statisticsSenderHandler = $statisticsSenderHandler;
        $this->map = $this->getInitialMap();
    }

    /**
     * @param TaskContract $taskContract
     * @return HandlerInterface[]
     */
    public function getTaskHandlers(TaskContract $taskContract): ?array
    {
        $task = get_class($taskContract);
        if (empty($this->getMap()[$task])) {
            return null;
        }

        return $this->getMap()[$task];
    }

    /**
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }

    public function replaceHandlers(string $task, array $handlers): self
    {
        $this->map[$task] = $handlers;
        return $this;
    }

    public function appendHandler(string $task, HandlerInterface $handler): self
    {
        $this->map[$task][] = $handler;
        return $this;
    }

    private function getInitialMap(): array
    {
        return [
            AddUserToBranchTask::class => [
                $this->addUserToBranchHandler,
            ],
            SendEventTask::class => [
                $this->statisticsSenderHandler,
            ],
        ];
    }
}
