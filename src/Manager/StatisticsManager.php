<?php

declare(strict_types=1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Events\EventDispatcher;
use Abrouter\Client\DTO\EventDTOInterface;
use Abrouter\Client\Events\Handlers\RelatedUsersStatisticsInterceptor;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Services\Statistics\SendEventTask;

class StatisticsManager
{
    private EventDispatcher $eventDispatcher;

    private ParallelRunSwitch $parallelRunSwitch;

    private RelatedUsersStatisticsInterceptor $relatedUsersStatisticsInterceptor;

    /**
     * @param EventDispatcher $eventDispatcher
     * @param ParallelRunSwitch $parallelRunSwitch
     * @param RelatedUsersStatisticsInterceptor $relatedUsersStatisticsInterceptor
     */
    public function __construct(
        EventDispatcher $eventDispatcher,
        ParallelRunSwitch $parallelRunSwitch,
        RelatedUsersStatisticsInterceptor $relatedUsersStatisticsInterceptor
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->parallelRunSwitch = $parallelRunSwitch;
        $this->relatedUsersStatisticsInterceptor = $relatedUsersStatisticsInterceptor;
    }

    public function sendEvent(EventDTOInterface $eventDTO): void
    {
        $task = new SendEventTask($eventDTO);
        $isParallelRunningEnabled = $this->parallelRunSwitch->isEnabled();
        if ($isParallelRunningEnabled) {
            $this->relatedUsersStatisticsInterceptor->handle($task);
        }

        $this->eventDispatcher->dispatch(
            $task,
            $isParallelRunningEnabled
        );
    }
}
