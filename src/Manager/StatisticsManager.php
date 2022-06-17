<?php

declare(strict_types=1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Events\EventDispatcher;
use Abrouter\Client\DTO\EventDTOInterface;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Services\Statistics\SendEventTask;

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

    public function sendEvent(EventDTOInterface $eventDTO): void
    {
        $this->eventDispatcher->dispatch(
            new SendEventTask($eventDTO),
            $this->parallelRunSwitch->isEnabled()
        );
    }
}
