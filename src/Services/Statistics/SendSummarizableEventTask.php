<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\Statistics;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\DTO\SummarizeEventDTO;

class SendSummarizableEventTask implements TaskContract
{
    private SummarizeEventDTO $summarizeEventDTO;

    public function __construct(SummarizeEventDTO $summarizeEventDTO)
    {
        $this->summarizeEventDTO = $summarizeEventDTO;
    }

    /**
     * @return SummarizeEventDTO
     */
    public function getSummarizableEventDTO(): SummarizeEventDTO
    {
        return $this->summarizeEventDTO;
    }
}
