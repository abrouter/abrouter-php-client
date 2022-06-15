<?php

namespace Abrouter\Client\DTO;

class IncrementEventDTO implements EventDTO
{
    /**
     * @var BaseEventDTO
     */
    private $baseEventDTO;

    public function __construct(BaseEventDTO $baseEventDTO)
    {
        $this->baseEventDTO = $baseEventDTO;
    }

    public function getBaseEventDTO(): BaseEventDTO
    {
        return $this->baseEventDTO;
    }
}