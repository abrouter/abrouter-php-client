<?php

declare(strict_types=1);

namespace Abrouter\Client\Entities;

class SentEvent
{
    /**
     * @var string
     */
    private $event;

    /**
     * @param string $event
     */
    public function __construct(
        string $event
    ) {
        $this->event = $event;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->event !== null;
    }
}
