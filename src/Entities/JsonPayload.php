<?php

declare(strict_types=1);

namespace Abrouter\Client\Entities;

class JsonPayload
{
    /**
     * @var array
     */
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
