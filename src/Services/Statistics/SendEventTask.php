<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\Statistics;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\DTO\EventDTO;

class SendEventTask implements TaskContract
{
    private EventDTO $eventDTO;

    public function __construct(EventDTO $eventDTO)
    {
        $this->eventDTO = $eventDTO;
    }

    /**
     * @return EventDTO
     */
    public function getEventDTO(): EventDTO
    {
        return $this->eventDTO;
    }
}
