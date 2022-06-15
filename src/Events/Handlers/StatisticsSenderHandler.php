<?php

declare(strict_types=1);

namespace Abrouter\Client\Events\Handlers;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\Events\HandlerInterface;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\SendEventRequestException;
use Abrouter\Client\Services\Statistics\SendEventService;
use Abrouter\Client\Services\Statistics\SendEventTask;

class StatisticsSenderHandler implements HandlerInterface
{
    private SendEventService $sendEventService;

    public function __construct(SendEventService $sendEventService)
    {
        $this->sendEventService = $sendEventService;
    }

    /**
     * @param TaskContract $taskContract
     * @return bool
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     */
    public function handle(TaskContract $taskContract): bool
    {
        if (!($taskContract instanceof SendEventTask)) {
            return false;
        }

        if ($taskContract->getEventDTO() instanceof IncrementEventDTO) {
            return $this->sendEventService->sendIncrementEvent(
                $taskContract->getEventDTO()
            )->isSuccessful();
        } else {
            return $this->sendEventService->sendSummarizableEvent(
                $taskContract->getEventDTO()
            )->isSuccessful();
        }

    }
}
