<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\Statistics;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\DTO\EventDTOInterface;

class SendEventTask implements TaskContract
{
    private EventDTOInterface $eventDTO;

    public function __construct(EventDTOInterface $eventDTO)
    {
        $this->eventDTO = $eventDTO;
    }

    /**
     * @return EventDTOInterface
     */
    public function getEventDTO(): EventDTOInterface
    {
        return $this->eventDTO;
    }
}
