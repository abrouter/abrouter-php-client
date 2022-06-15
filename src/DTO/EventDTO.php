<?php

declare(strict_types=1);

namespace Abrouter\Client\DTO;

interface EventDTO
{
    public function getBaseEventDTO (): BaseEventDTO;
}
