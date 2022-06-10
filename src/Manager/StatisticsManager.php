<?php

declare(strict_types=1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;
use Abrouter\Client\Events\EventDispatcher;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Services\Statistics\SendIncrementEventTask;
use Abrouter\Client\Services\Statistics\SendSummarizableEventTask;

class StatisticsManager
{
    private EventDispatcher $eventDispatcher;

    private ParallelRunSwitch $parallelRunSwitch;

    /**
     * @param EventDispatcher $eventDispatcher
     * @param ParallelRunSwitch $parallelRunSwitch
     */
    public function __construct(EventDispatcher $eventDispatcher, ParallelRunSwitch $parallelRunSwitch)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->parallelRunSwitch = $parallelRunSwitch;
    }

    public function sendIncrementEvent(IncrementEventDTO $eventDTO): void
    {
        $this->eventDispatcher->dispatch(
            new SendIncrementEventTask($eventDTO),
            $this->parallelRunSwitch->isEnabled()
        );
    }

    public function sendSummarizableEvent(SummarizeEventDTO $eventDTO): void
    {
        $this->eventDispatcher->dispatch(
            new SendSummarizableEventTask($eventDTO),
            $this->parallelRunSwitch->isEnabled()
        );
    }
}
