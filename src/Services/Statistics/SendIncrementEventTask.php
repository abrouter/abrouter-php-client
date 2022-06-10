<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\Statistics;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\DTO\IncrementEventDTO;

class SendIncrementEventTask implements TaskContract
{
    private IncrementEventDTO $incrementEventDTO;

    public function __construct(IncrementEventDTO $incrementEventDTO)
    {
        $this->incrementEventDTO = $incrementEventDTO;
    }

    /**
     * @return IncrementEventDTO
     */
    public function getIncrementEventDTO(): IncrementEventDTO
    {
        return $this->incrementEventDTO;
    }
}
