<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Collections;

use Abrouter\Client\RemoteEntity\Entities\StatisticEvent;

class StatisticEventsCollection
{
    /**
     * @var StatisticEvent[]
     */
    private array $statisticEvents;

    public function __construct(StatisticEvent ...$statisticEvents)
    {
        $this->statisticEvents = $statisticEvents;
    }

    /**
     * @return StatisticEvent[]
     */
    public function getStatisticEvents(): array
    {
        return $this->statisticEvents;
    }
}
