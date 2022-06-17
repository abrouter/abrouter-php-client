<?php

namespace Abrouter\Client\DTO;

class SummarizeEventDTO implements EventDTOInterface
{
    /**
     * @var BaseEventDTO
     */
    private $baseEventDTO;

    /**
     * @var string
     */
    private $value;

    public function __construct(string $value, BaseEventDTO $baseEventDTO)
    {
        $this->value = $value;
        $this->baseEventDTO = $baseEventDTO;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getBaseEventDTO(): BaseEventDTO
    {
        return $this->baseEventDTO;
    }
}
